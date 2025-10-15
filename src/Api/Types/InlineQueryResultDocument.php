<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\InlineKeyboardMarkup;
use MemoGram\Api\Types\InputMessageContent;


class InlineQueryResultDocument
{
    use Concerns\Data;

    public function __construct(
        /** @var string Type of the result, must be document */
        public string $type,
        
        /** @var string Unique identifier for this result, 1-64 bytes */
        public string $id,
        
        /** @var string Title for the result */
        public string $title,
        
        /** @var string|null Optional. Caption of the document to be sent, 0-1024 characters after entities parsing */
        public null|string $caption = null,
        
        /** @var string|null Optional. Mode for parsing entities in the document caption. See formatting options for more details. */
        public null|string $parse_mode = null,
        
        /** @var array<\MemoGram\Api\Types\MessageEntity>|null Optional. List of special entities that appear in the caption, which can be specified instead of parse_mode */
        public null|array $caption_entities = null,
        
        /** @var string A valid URL for the file */
        public string $document_url,
        
        /** @var string MIME type of the content of the file, either “application/pdf” or “application/zip” */
        public string $mime_type,
        
        /** @var string|null Optional. Short description of the result */
        public null|string $description = null,
        
        /** @var InlineKeyboardMarkup|null Optional. Inline keyboard attached to the message */
        public null|InlineKeyboardMarkup $reply_markup = null,
        
        /** @var InputMessageContent|null Optional. Content of the message to be sent instead of the file */
        public null|InputMessageContent $input_message_content = null,
        
        /** @var string|null Optional. URL of the thumbnail (JPEG only) for the file */
        public null|string $thumbnail_url = null,
        
        /** @var int|null Optional. Thumbnail width */
        public null|int $thumbnail_width = null,
        
        /** @var int|null Optional. Thumbnail height */
        public null|int $thumbnail_height = null,
        
        
    ) { }
}
