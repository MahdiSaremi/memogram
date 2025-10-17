<?php

namespace MemoGram\Tests\Handle;

use MemoGram\Handle\Event;

class FakeEvent implements Event
{
    public function __construct(
        public null|string|int $chatId,
        public null|string|int $userId,
        public null|string|int $userMessageId,
    )
    {
    }

    public function getChatId(): null|string|int
    {
        return $this->chatId;
    }

    public function getUserId(): null|string|int
    {
        return $this->userId;
    }

    public function getUserMessageId(): null|string|int
    {
        return $this->userMessageId;
    }
}