<?php

namespace MemoGram\Matching\Listeners;

use MemoGram\Api\Types\Message;
use MemoGram\Api\Types\Update;
use MemoGram\Handle\Event;
use MemoGram\Matching\MatchHelper;

class OnCommand extends BaseListener
{
    public ?array $types = null;
    public null|string|false $message = false;
    protected string $lastContent = "";

    public function __construct(
        protected string $command,
    )
    {
    }

    public function message(null|string|false $message)
    {
        if ($this->types === null) {
            $this->types = [Message::TYPE_TEXT];
        }

        $this->message = $message;
        return $this;
    }

    public function runCheck(Event $event, MatchHelper $match): bool
    {
        return $match->beMessage($event, $message)
            && $match->messageMatchType($message, ['text'], $type)
            && $this->test($event)
            && parent::runCheck($event, $match);
    }

    protected function test(Event $event): bool
    {
        if (
            $event instanceof Update &&
            preg_match('/^' . preg_quote((str_starts_with($this->command, '/') ? '' : '/') . $this->command) . '($|[\s\r\n]+)/i', $event->message->text, $matches)
        ) {
            $this->lastContent = substr($event->message->text, strlen($matches[0]));
            return true;
        }

        return false;
    }

    protected function getArguments(): array
    {
        return [
            $this->lastContent,
        ];
    }
}