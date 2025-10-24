<?php

namespace MemoGram\Handle;

use Closure;
use Illuminate\Database\Eloquent\Collection;
use MemoGram\Api\TelegramApi;
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

    public function routes(string|Closure $path): void
    {
        $this->staticListener->changeAsCurrent(function () use ($path) {
            if (is_string($path)) {
                require $path;
            } else {
                $path();
            }
        });
    }

    public function handle(Event $event): void
    {
        $this->handleUsing($event, function () use ($event) {
            $this->pushEvent($event);
        });
    }

    public function handleUsing(Event $event, Closure $callback): void
    {
        $old = static::$current;

        try {
            static::$current = new Context(
                handler: $this,
                event: $event,
            );

            $callback();
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
     * @param Closure $then
     * @param array $args
     * @return Closure
     */
    public function createMiddlewarePipeline(array $middlewares, Closure $then, array $args = []): Closure
    {
        if (!$middlewares && !$args) {
            return $then;
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
        $this->streamResponse($response, function (AsResponse $response, string $key) {
            $response->runResponse($this->pageStack ? end($this->pageStack) : null, $key);
        });
    }

    public function streamResponse(mixed $response, Closure $callback): void
    {
        $this->streamSubResponse($response, $callback);
    }

    protected function streamSubResponse(mixed $response, Closure $callback, string $id = null): void
    {
        if (is_null($response)) {
            return;
        }

        if (is_string($response)) {
            $callback((new MessageResponse())->message($response), $id ?? '0');
            return;
        }

        if (is_array($response) || $response instanceof \Iterator) {
            foreach ($response as $_id => $resp) {
                $this->streamSubResponse($resp, $callback, is_int($_id) ? (($id !== null ? $id . '.' : '') . $_id) : $_id);
            }
            return;
        }

        if ($response instanceof AsResponse) {
            $callback($response, $response->id ?? $id ?? '0');
            return;
        }

        throw new \TypeError("Expected AsResponse type, got " . is_object($response) ? get_class($response) : gettype($response));
    }
}
