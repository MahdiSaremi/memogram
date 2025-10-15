<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\InputMessageContent;
use MemoGram\Api\Types\InlineKeyboardMarkup;


class InlineQueryResultArticle
{
    use Concerns\Data;

    public function __construct(
        /** @var string Type of the result, must be article */
        public string $type,
        
        /** @var string Unique identifier for this result, 1-64 Bytes */
        public string $id,
        
        /** @var string Title of the result */
        public string $title,
        
        /** @var InputMessageContent Content of the message to be sent */
        public InputMessageContent $input_message_content,
        
        /** @var InlineKeyboardMarkup|null Optional. Inline keyboard attached to the message */
        public null|InlineKeyboardMarkup $reply_markup = null,
        
        /** @var string|null Optional. URL of the result */
        public null|string $url = null,
        
        /** @var string|null Optional. Short description of the result */
        public null|string $description = null,
        
        /** @var string|null Optional. Url of the thumbnail for the result */
        public null|string $thumbnail_url = null,
        
        /** @var int|null Optional. Thumbnail width */
        public null|int $thumbnail_width = null,
        
        /** @var int|null Optional. Thumbnail height */
        public null|int $thumbnail_height = null,
        
        
    ) { }
}
