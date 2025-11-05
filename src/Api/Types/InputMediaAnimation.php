<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class InputMediaAnimation extends InputMedia
{
    use Concerns\Data;

    /** @var string Type of the result, must be animation */
    public string $type = 'animation';

    public function __construct(
        /** @var string File to send. Pass a file_id to send a file that exists on the Telegram servers (recommended), pass an HTTP URL for Telegram to get a file from the Internet, or pass “attach://<file_attach_name>” to upload a new one using multipart/form-data under <file_attach_name> name. More information on Sending Files » */
        public string $media,
        
        /** @var string|null Optional. Thumbnail of the file sent; can be ignored if thumbnail generation for the file is supported server-side. The thumbnail should be in JPEG format and less than 200 kB in size. A thumbnail's width and height should not exceed 320. Ignored if the file is not uploaded using multipart/form-data. Thumbnails can't be reused and can be only uploaded as a new file, so you can pass “attach://<file_attach_name>” if the thumbnail was uploaded using multipart/form-data under <file_attach_name>. More information on Sending Files » */
        public null|string $thumbnail = null,
        
        /** @var string|null Optional. Caption of the animation to be sent, 0-1024 characters after entities parsing */
        public null|string $caption = null,
        
        /** @var string|null Optional. Mode for parsing entities in the animation caption. See formatting options for more details. */
        public null|string $parse_mode = null,
        
        /** @var array<\MemoGram\Api\Types\MessageEntity>|null Optional. List of special entities that appear in the caption, which can be specified instead of parse_mode */
        public null|array $caption_entities = null,
        
        /** @var bool|null Optional. Pass True, if the caption must be shown above the message media */
        public null|bool $show_caption_above_media = null,
        
        /** @var int|null Optional. Animation width */
        public null|int $width = null,
        
        /** @var int|null Optional. Animation height */
        public null|int $height = null,
        
        /** @var int|null Optional. Animation duration in seconds */
        public null|int $duration = null,
        
        /** @var bool|null Optional. Pass True if the animation needs to be covered with a spoiler animation */
        public null|bool $has_spoiler = null,
        
        
    ) { }
}
