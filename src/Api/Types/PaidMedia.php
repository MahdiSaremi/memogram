<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;


abstract class PaidMedia
{
    public static function makeDynamic(array $data): self
    {
        return match ($data['type']) {
            'preview' => PaidMediaPreview::makeFromArray($data),
            'photo' => PaidMediaPhoto::makeFromArray($data),
            'video' => PaidMediaVideo::makeFromArray($data),
        };
    }
}
