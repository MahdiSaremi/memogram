<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class InlineKeyboardMarkup
{
    use Concerns\Data;

    public function __construct(
        /** @var array<\MemoGram\Api\Types\array<\MemoGram\Api\Types\InlineKeyboardButton>> Array of button rows, each represented by an Array of InlineKeyboardButton objects */
        public array $inline_keyboard,
        
        
    ) { }
}
