<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class InputMediaPhoto extends InputMedia
{
    use Concerns\Data;

    /** @var string Type of the result, must be photo */
    public string $type = 'photo';

    public function __construct(
        /** @var string File to send. Pass a file_id to send a file that exists on the Telegram servers (recommended), pass an HTTP URL for Telegram to get a file from the Internet, or pass “attach://<file_attach_name>” to upload a new one using multipart/form-data under <file_attach_name> name. More information on Sending Files » */
        public string $media,
        
        /** @var string|null Optional. Caption of the photo to be sent, 0-1024 characters after entities parsing */
        public null|string $caption = null,
        
        /** @var string|null Optional. Mode for parsing entities in the photo caption. See formatting options for more details. */
        public null|string $parse_mode = null,
        
        /** @var array<\MemoGram\Api\Types\MessageEntity>|null Optional. List of special entities that appear in the caption, which can be specified instead of parse_mode */
        public null|array $caption_entities = null,
        
        /** @var bool|null Optional. Pass True, if the caption must be shown above the message media */
        public null|bool $show_caption_above_media = null,
        
        /** @var bool|null Optional. Pass True if the photo needs to be covered with a spoiler animation */
        public null|bool $has_spoiler = null,
        
        
    ) { }
}
