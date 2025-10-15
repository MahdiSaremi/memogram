<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class TextQuote
{
    use Concerns\Data;

    public function __construct(
        /** @var string Text of the quoted part of a message that is replied to by the given message */
        public string $text,
        
        /** @var array<\MemoGram\Api\Types\MessageEntity>|null Optional. Special entities that appear in the quote. Currently, only bold, italic, underline, strikethrough, spoiler, and custom_emoji entities are kept in quotes. */
        public null|array $entities = null,
        
        /** @var int Approximate quote position in the original message in UTF-16 code units as specified by the sender */
        public int $position,
        
        /** @var bool|null Optional. True, if the quote was chosen manually by the message sender. Otherwise, the quote was added automatically by the server. */
        public null|bool $is_manual = null,
        
        
    ) { }
}
