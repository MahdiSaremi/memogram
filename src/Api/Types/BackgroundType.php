<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\BackgroundFill;


abstract class BackgroundType
{
    public static function makeDynamic(array $data): self
    {
        return match ($data['type']) {
            'fill' => BackgroundTypeFill::makeFromArray($data),
            'wallpaper' => BackgroundTypeWallpaper::makeFromArray($data),
            'pattern' => BackgroundTypePattern::makeFromArray($data),
            'chat_theme' => BackgroundTypeChatTheme::makeFromArray($data),
        };
    }
}
