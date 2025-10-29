<?php

namespace MemoGram\Handle;

use Closure;
use Generator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use MemoGram\Api\TelegramApi;
use MemoGram\Exceptions\StopPage;
use MemoGram\Handle\Middleware\Middleware;
use MemoGram\Matching\ListenerDispatcher;
use MemoGram\Models\PageCellModel;
use MemoGram\Models\PageModel;
use MemoGram\Models\PageUseModel;
use MemoGram\Response\AsResponse;
use MemoGram\Response\MessageResponse;
use function MemoGram\Hooks\open;

class EventHandler
{
    public static ?Context $current = null;

    protected ListenerDispatcher $staticListener;
    protected array $globalMiddlewares = [];

    /**
     * @var Page[]
     */
    public array $pageStack = [];

    public function __construct(
        public TelegramApi $api,
    )
    {
        $this->staticListener = new ListenerDispatcher();
    }

    public static function make(TelegramApi|string $api): static
    {
        if (is_string($api)) {
            $api = new TelegramApi($api);
        }

        return new static($api);
    }

    public function routes(string|Closure $path)
    {
        $this->staticListener->changeAsCurrent(function () use ($path) {
            if (is_string($path)) {
                require $path;
            } else {
                $path();
            }
        });

        return $this;
    }

    public function withGlobalMiddleware($middleware): void
    {
        array_push($this->globalMiddlewares, ...Arr::wrap($middleware));
    }

    public function useContext(Closure $callback): void
    {
        $this->handleUsing(null, $callback);
    }

    public function handle(Event $event): void
    {
        $this->handleUsing($event, function () use ($event) {
            $this->pushEvent($event);
        });
    }

    public function handleUsing(?Event $event, Closure $callback): void
    {
        $old = static::$current;

        try {
            static::$current = new Context(
                handler: $this,
                event: $event,
            );

            $this->createMiddlewarePipeline($this->globalMiddlewares, $callback)();
        } finally {
            static::$current = $old;
        }
    }

    protected function pushEvent(Event $event): void
    {
        $tablePage = (new PageModel)->getTable();
        $tableUse = (new PageUseModel)->getTable();
        $tableCell = (new PageCellModel)->getTable();

        $visitedList = [];

        $pipes = array_filter([
            // By is_taking_control property
            function (Event $event, Closure $next) use ($visitedList, $tableCell, $tableUse) {
                return $this->hydratePageAndPushEvent(
                    $visitedList,
                    ($chatId = $event->getChatId()) ? PageCellModel::query()
                        ->leftJoin($tableUse, "{$tableUse}.id", "=", "{$tableCell}.use_id")
                        ->where('is_taking_control', true)
                        ->where("{$tableUse}.chat_id", $chatId)
                        ->select("{$tableCell}.*")
                        ->latest('id')
                        ->first()?->use : null,
                    $event,
                    $next,
                );
            },
            // By interaction message
            function (Event $event, Closure $next) use ($visitedList, $tableCell, $tableUse) {
                return $this->hydratePageAndPushEvent(
                    $visitedList,
                    ($chatId = $event->getChatId()) && ($interactionId = $event->getInteractionMessageId()) ? PageUseModel::query()
                        ->leftJoin($tableCell, "{$tableUse}.id", "=", "{$tableCell}.use_id")
                        ->where("{$tableUse}.chat_id", $chatId)
                        ->where("{$tableCell}.message_id", $interactionId)
                        ->select("{$tableUse}.*")
                        ->latest('id')
                        ->get() : null,
                    $event,
                    $next,
                );
            },
            // Static listeners
            $this->staticListener->pushEventAsPipe(...),
        ]);

        $this->pushPipes($event, $pipes);
    }

    protected function hydratePageAndPushEvent(array &$visitedList, null|PageUseModel|Collection $use, Event $event, Closure $next): bool
    {
        if ($use === null) {
            $use = [];
        } elseif ($use instanceof PageUseModel) {
            $use = [$use];
        }

        $i = 0;
        $nextLocal = static function (Event $event) use (&$use, &$i, &$nextLocal, &$visitedList, $next) {
            if ($usage = @$use[$i++]) {
                if (!in_array($usage->id, $visitedList)) {
                    $visitedList[] = $usage->id;

                    $page = new Page($usage->page->reference);
                    $page->hydrate($usage);

                    return $page->pushHydratedEvent($event, $nextLocal);
                } else {
                    return $nextLocal($event);
                }
            }

            return $next($event);
        };

        return $nextLocal($event);
    }

    protected function pushPipes(Event $event, array $pipes): bool
    {
        $i = 0;
        $next = static function (Event $event) use (&$pipes, &$i, &$next) {
            $pipe = @$pipes[$i++];

            return $pipe ? $pipe($event, $next) : false;
        };

        return $next($event);
    }

    public function staticListen(Closure $using): void
    {
        $using($this->staticListener);
    }


    /**
     * @param Middleware[] $middlewares
     * @param Closure|string|array $then
     * @param array $args
     * @return Closure|string|array
     */
    public function createMiddlewarePipeline(array $middlewares, $then, array $args = []): Closure|string|array
    {
        if (!$middlewares && !$args) {
            return $then;
        }

        if (is_string($then) || is_array($then)) {
            $then = static fn(...$args) => open($then, $args);
        }

        $i = 0;
        $next = static function () use ($args, $middlewares, &$i, $then, &$next) {
            if ($i < count($middlewares)) {
                return $middlewares[$i++]->handle($next);
            } else {
                return $then(...$args);
            }
        };

        return $next;
    }

    public function runAction($callback, array $args = []): void
    {
        if (is_string($callback) || is_array($callback)) {
            open($callback);
            return;
        }

        context()->handler->handleResponse(
            $callback(...$args),
        );
    }


    public function handleResponse(mixed $response): void
    {
        foreach ($this->eachResponse($response) as $key => $response) {
            $response->runResponse($this->pageStack ? end($this->pageStack) : null, $key);
        };
    }

    /**
     * @param mixed $response
     * @return Generator<string, AsResponse>
     */
    public function eachResponse(mixed $response): Generator
    {
        foreach ($this->eachSubResponse($response) as $key => $response) {
            if ($response instanceof StopPage) {
                return;
            }

            yield $key => $response;
        }
    }

    public function streamResponse(mixed $response, Closure $callback): void
    {
        foreach ($this->eachResponse($response) as $key => $response) {
            $callback($response, $key);
        }
    }

    /**
     * @param mixed $response
     * @param string|null $id
     * @return Generator<string, AsResponse>
     */
    protected function eachSubResponse(mixed $response, string $id = null): Generator
    {
        if (is_null($response)) {
            return;
        }

        if (is_string($response)) {
            yield $id ?? '0' => (new MessageResponse())->message($response);
            return;
        }

        if (is_array($response) || $response instanceof \Iterator) {
            foreach ($response as $_id => $resp) {
                yield from $this->eachSubResponse($resp, is_int($_id) ? (($id !== null ? $id . '.' : '') . $_id) : $_id);
            }
            return;
        }

        if ($response instanceof AsResponse) {
            yield $response->id ?? $id ?? '0' => $response;
            return;
        }

        if ($response instanceof StopPage) {
            yield $response;
            return;
        }

        throw new \TypeError("Expected AsResponse type, got " . is_object($response) ? get_class($response) : gettype($response));
    }
}
