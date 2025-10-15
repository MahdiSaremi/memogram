<?php

namespace MemoGram\Handle;

interface Event
{
    public function getChatId(): null|string|int;

    public function getUserId(): null|string|int;

    public function getUserMessageId(): null|string|int;
}