<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\User;


abstract class MessageOrigin
{
    public static function makeDynamic(array $data): self
    {
        return match ($data['type']) {
            'user' => MessageOriginUser::makeFromArray($data),
            'hidden_user' => MessageOriginHiddenUser::makeFromArray($data),
            'chat' => MessageOriginChat::makeFromArray($data),
            'channel' => MessageOriginChannel::makeFromArray($data),
        };
    }
}
