<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\InlineKeyboardMarkup;
use MemoGram\Api\Types\InputMessageContent;


class InlineQueryResultVoice
{
    use Concerns\Data;

    public function __construct(
        /** @var string Type of the result, must be voice */
        public string $type,
        
        /** @var string Unique identifier for this result, 1-64 bytes */
        public string $id,
        
        /** @var string A valid URL for the voice recording */
        public string $voice_url,
        
        /** @var string Recording title */
        public string $title,
        
        /** @var string|null Optional. Caption, 0-1024 characters after entities parsing */
        public null|string $caption = null,
        
        /** @var string|null Optional. Mode for parsing entities in the voice message caption. See formatting options for more details. */
        public null|string $parse_mode = null,
        
        /** @var array<\MemoGram\Api\Types\MessageEntity>|null Optional. List of special entities that appear in the caption, which can be specified instead of parse_mode */
        public null|array $caption_entities = null,
        
        /** @var int|null Optional. Recording duration in seconds */
        public null|int $voice_duration = null,
        
        /** @var InlineKeyboardMarkup|null Optional. Inline keyboard attached to the message */
        public null|InlineKeyboardMarkup $reply_markup = null,
        
        /** @var InputMessageContent|null Optional. Content of the message to be sent instead of the voice recording */
        public null|InputMessageContent $input_message_content = null,
        
        
    ) { }
}
