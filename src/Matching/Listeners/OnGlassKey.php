<?php

namespace MemoGram\Matching\Listeners;

use MemoGram\Handle\Event;
use MemoGram\Matching\MatcherHelper;
use MemoGram\Response\GlassKey;
use MemoGram\Response\Key;
use function MemoGram\Handle\context;

class OnGlassKey extends BaseListener
{
    public function __construct(
        public GlassKey $key,
    )
    {
    }

    public function runCheck(Event $event, MatcherHelper $match): bool
    {
        return $match->beCallbackQuery($event, $callbackQuery)
            && $callbackQuery->data === self::getDataOf($this->key);
    }

    public function runAction(Event $event): void
    {
        if ($this->key->then) {
            context()->handler->runAction($this->key->then);
        }

        parent::runAction($event);
    }

    public static function getDataOf(GlassKey $key): string
    {
        if (!$key->then) {
            return '~';
        }

        return '~' . ($key->id ?? $key->text);
    }
}