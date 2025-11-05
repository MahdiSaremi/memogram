<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\Gift;
use MemoGram\Api\Types\User;


abstract class OwnedGift
{
    public static function makeDynamic(array $data): self
    {
        return match ($data['type']) {
            'regular' => OwnedGiftRegular::makeFromArray($data),
            'unique' => OwnedGiftUnique::makeFromArray($data),
        };
    }
}
