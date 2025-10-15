<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\LinkPreviewOptions;


class InputTextMessageContent
{
    use Concerns\Data;

    public function __construct(
        /** @var string Text of the message to be sent, 1-4096 characters */
        public string $message_text,
        
        /** @var string|null Optional. Mode for parsing entities in the message text. See formatting options for more details. */
        public null|string $parse_mode = null,
        
        /** @var array<\MemoGram\Api\Types\MessageEntity>|null Optional. List of special entities that appear in message text, which can be specified instead of parse_mode */
        public null|array $entities = null,
        
        /** @var LinkPreviewOptions|null Optional. Link preview generation options for the message */
        public null|LinkPreviewOptions $link_preview_options = null,
        
        
    ) { }
}
