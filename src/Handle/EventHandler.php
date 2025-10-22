<?php

namespace MemoGram\Handle;

use Closure;
use Illuminate\Database\Eloquent\Collection;
use MemoGram\Api\TelegramApi;
use MemoGram\Matching\ListenerMatcher;
use MemoGram\Models\PageCellModel;
use MemoGram\Models\PageModel;
use MemoGram\Models\PageUseModel;
use MemoGram\Response\AsResponse;
use MemoGram\Response\MessageResponse;

class EventHandler
{
    public static ?Context $current = null;

    protected ListenerMatcher $staticListener;

    /**
     * @var Page[]
     */
    public array $pageStack = [];

    public function __construct(
        public TelegramApi $api,
    )
    {
        $this->staticListener = new ListenerMatcher();
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


    public function runAction(Closure $callback, array $args = []): void
    {
        context()->handler->handleResponse(
            $callback(...$args),
        );
    }


    public function handleResponse(mixed $response): void
    {
        $responses = $this->normalizeResponse($response);

        /**
         * @var string $key
         * @var AsResponse $response
         */
        foreach ($responses as [$key, $response]) {
            $response->runResponse($this->pageStack ? end($this->pageStack) : null, $key);
        }
    }

    /**
     * @param mixed $response
     * @return array<(AsResponse|string)[]>
     */
    public function normalizeResponse(mixed $response): array
    {
        return $this->assignResponsesKey($this->responseToArray($response));
    }

    protected function responseToArray(mixed $response): array
    {
        return match (true) {
            is_null($response)
            => [],

            is_string($response)
            => [(new MessageResponse())->message($response)],

            is_array($response)
            => collect($response)->map($this->responseToArray(...))->flatten(1)->all(),

            $response instanceof \Iterator
            => collect(iterator_to_array($response))->map($this->responseToArray(...))->flatten(1)->all(),

            is_object($response)
            => [$response],
        };
    }

    protected function assignResponsesKey(array $responses): array
    {
        $all = [];
        foreach ($responses as $index => $response) {
            $key = $response->id ?? "$index";

            $all[] = [$key, $response];
        }

        return $all;
    }
}
