<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class InputChecklistTask
{
    use Concerns\Data;

    public function __construct(
        /** @var int Unique identifier of the task; must be positive and unique among all task identifiers currently present in the checklist */
        public int $id,
        
        /** @var string Text of the task; 1-100 characters after entities parsing */
        public string $text,
        
        /** @var string|null Optional. Mode for parsing entities in the text. See formatting options for more details. */
        public null|string $parse_mode = null,
        
        /** @var array<\MemoGram\Api\Types\MessageEntity>|null Optional. List of special entities that appear in the text, which can be specified instead of parse_mode. Currently, only bold, italic, underline, strikethrough, spoiler, and custom_emoji entities are allowed. */
        public null|array $text_entities = null,
        
        
    ) { }
}
