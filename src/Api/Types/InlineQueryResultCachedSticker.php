<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\InlineKeyboardMarkup;
use MemoGram\Api\Types\InputMessageContent;


class InlineQueryResultCachedSticker
{
    use Concerns\Data;

    public function __construct(
        /** @var string Type of the result, must be sticker */
        public string $type,
        
        /** @var string Unique identifier for this result, 1-64 bytes */
        public string $id,
        
        /** @var string A valid file identifier of the sticker */
        public string $sticker_file_id,
        
        /** @var InlineKeyboardMarkup|null Optional. Inline keyboard attached to the message */
        public null|InlineKeyboardMarkup $reply_markup = null,
        
        /** @var InputMessageContent|null Optional. Content of the message to be sent instead of the sticker */
        public null|InputMessageContent $input_message_content = null,
        
        
    ) { }
}
