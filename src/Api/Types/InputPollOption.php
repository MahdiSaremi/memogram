<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class InputPollOption
{
    use Concerns\Data;

    public function __construct(
        /** @var string Option text, 1-100 characters */
        public string $text,
        
        /** @var string|null Optional. Mode for parsing entities in the text. See formatting options for more details. Currently, only custom emoji entities are allowed */
        public null|string $text_parse_mode = null,
        
        /** @var array<\MemoGram\Api\Types\MessageEntity>|null Optional. A JSON-serialized list of special entities that appear in the poll option text. It can be specified instead of text_parse_mode */
        public null|array $text_entities = null,
        
        
    ) { }
}
