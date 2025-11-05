<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\LocationAddress;


abstract class StoryAreaType
{
    public static function makeDynamic(array $data): self
    {
        return match ($data['type']) {
            'location' => StoryAreaTypeLocation::makeFromArray($data),
            'suggested_reaction' => StoryAreaTypeSuggestedReaction::makeFromArray($data),
            'link' => StoryAreaTypeLink::makeFromArray($data),
            'weather' => StoryAreaTypeWeather::makeFromArray($data),
            'unique_gift' => StoryAreaTypeUniqueGift::makeFromArray($data),
        };
    }
}
