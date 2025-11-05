<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;


abstract class BackgroundFill
{
    public static function makeDynamic(array $data): self
    {
        return match ($data['type']) {
            'solid' => BackgroundFillSolid::makeFromArray($data),
            'gradient' => BackgroundFillGradient::makeFromArray($data),
            'freeform_gradient' => BackgroundFillFreeformGradient::makeFromArray($data),
        };
    }
}
