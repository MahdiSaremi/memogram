<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\InlineKeyboardMarkup;
use MemoGram\Api\Types\InputMessageContent;


class InlineQueryResultPhoto
{
    use Concerns\Data;

    public function __construct(
        /** @var string Type of the result, must be photo */
        public string $type,
        
        /** @var string Unique identifier for this result, 1-64 bytes */
        public string $id,
        
        /** @var string A valid URL of the photo. Photo must be in JPEG format. Photo size must not exceed 5MB */
        public string $photo_url,
        
        /** @var string URL of the thumbnail for the photo */
        public string $thumbnail_url,
        
        /** @var int|null Optional. Width of the photo */
        public null|int $photo_width = null,
        
        /** @var int|null Optional. Height of the photo */
        public null|int $photo_height = null,
        
        /** @var string|null Optional. Title for the result */
        public null|string $title = null,
        
        /** @var string|null Optional. Short description of the result */
        public null|string $description = null,
        
        /** @var string|null Optional. Caption of the photo to be sent, 0-1024 characters after entities parsing */
        public null|string $caption = null,
        
        /** @var string|null Optional. Mode for parsing entities in the photo caption. See formatting options for more details. */
        public null|string $parse_mode = null,
        
        /** @var array<\MemoGram\Api\Types\MessageEntity>|null Optional. List of special entities that appear in the caption, which can be specified instead of parse_mode */
        public null|array $caption_entities = null,
        
        /** @var bool|null Optional. Pass True, if the caption must be shown above the message media */
        public null|bool $show_caption_above_media = null,
        
        /** @var InlineKeyboardMarkup|null Optional. Inline keyboard attached to the message */
        public null|InlineKeyboardMarkup $reply_markup = null,
        
        /** @var InputMessageContent|null Optional. Content of the message to be sent instead of the photo */
        public null|InputMessageContent $input_message_content = null,
        
        
    ) { }
}
