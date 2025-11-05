<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;


abstract class ReactionType
{
    public static function makeDynamic(array $data): self
    {
        return match ($data['type']) {
            'emoji' => ReactionTypeEmoji::makeFromArray($data),
            'custom_emoji' => ReactionTypeCustomEmoji::makeFromArray($data),
            'paid' => ReactionTypePaid::makeFromArray($data),
        };
    }
}
