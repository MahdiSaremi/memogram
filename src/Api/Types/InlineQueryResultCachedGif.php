<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\InlineKeyboardMarkup;
use MemoGram\Api\Types\InputMessageContent;


class InlineQueryResultCachedGif
{
    use Concerns\Data;

    public function __construct(
        /** @var string Type of the result, must be gif */
        public string $type,
        
        /** @var string Unique identifier for this result, 1-64 bytes */
        public string $id,
        
        /** @var string A valid file identifier for the GIF file */
        public string $gif_file_id,
        
        /** @var string|null Optional. Title for the result */
        public null|string $title = null,
        
        /** @var string|null Optional. Caption of the GIF file to be sent, 0-1024 characters after entities parsing */
        public null|string $caption = null,
        
        /** @var string|null Optional. Mode for parsing entities in the caption. See formatting options for more details. */
        public null|string $parse_mode = null,
        
        /** @var array<\MemoGram\Api\Types\MessageEntity>|null Optional. List of special entities that appear in the caption, which can be specified instead of parse_mode */
        public null|array $caption_entities = null,
        
        /** @var bool|null Optional. Pass True, if the caption must be shown above the message media */
        public null|bool $show_caption_above_media = null,
        
        /** @var InlineKeyboardMarkup|null Optional. Inline keyboard attached to the message */
        public null|InlineKeyboardMarkup $reply_markup = null,
        
        /** @var InputMessageContent|null Optional. Content of the message to be sent instead of the GIF animation */
        public null|InputMessageContent $input_message_content = null,
        
        
    ) { }
}
