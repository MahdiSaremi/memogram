<?php

namespace MemoGram\Handle;

use Closure;
use MemoGram\Api\TelegramApi;
use MemoGram\Response\AsResponse;
use MemoGram\Response\MessageResponse;

class EventHandler
{
    public static ?Context $current = null;

    /**
     * @var Page[]
     */
    public array $pageStack = [];

    public function __construct(
        public TelegramApi $api,
    )
    {
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
            $response->runResponse(end($this->pageStack), $key);
        }
    }

    /**
     * @param mixed $response
     * @return array<(AsResponse|string)[]>
     */
    protected function normalizeResponse(mixed $response): array
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