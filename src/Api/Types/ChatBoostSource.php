<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;


abstract class ChatBoostSource
{
    public static function makeDynamic(array $data): self
    {
        return match ($data['source']) {
            'premium' => ChatBoostSourcePremium::makeFromArray($data),
            'gift_code' => ChatBoostSourceGiftCode::makeFromArray($data),
            'giveaway' => ChatBoostSourceGiveaway::makeFromArray($data),
        };
    }
}
