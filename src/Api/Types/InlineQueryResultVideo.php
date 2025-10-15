<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\InlineKeyboardMarkup;
use MemoGram\Api\Types\InputMessageContent;


class InlineQueryResultVideo
{
    use Concerns\Data;

    public function __construct(
        /** @var string Type of the result, must be video */
        public string $type,
        
        /** @var string Unique identifier for this result, 1-64 bytes */
        public string $id,
        
        /** @var string A valid URL for the embedded video player or video file */
        public string $video_url,
        
        /** @var string MIME type of the content of the video URL, “text/html” or “video/mp4” */
        public string $mime_type,
        
        /** @var string URL of the thumbnail (JPEG only) for the video */
        public string $thumbnail_url,
        
        /** @var string Title for the result */
        public string $title,
        
        /** @var string|null Optional. Caption of the video to be sent, 0-1024 characters after entities parsing */
        public null|string $caption = null,
        
        /** @var string|null Optional. Mode for parsing entities in the video caption. See formatting options for more details. */
        public null|string $parse_mode = null,
        
        /** @var array<\MemoGram\Api\Types\MessageEntity>|null Optional. List of special entities that appear in the caption, which can be specified instead of parse_mode */
        public null|array $caption_entities = null,
        
        /** @var bool|null Optional. Pass True, if the caption must be shown above the message media */
        public null|bool $show_caption_above_media = null,
        
        /** @var int|null Optional. Video width */
        public null|int $video_width = null,
        
        /** @var int|null Optional. Video height */
        public null|int $video_height = null,
        
        /** @var int|null Optional. Video duration in seconds */
        public null|int $video_duration = null,
        
        /** @var string|null Optional. Short description of the result */
        public null|string $description = null,
        
        /** @var InlineKeyboardMarkup|null Optional. Inline keyboard attached to the message */
        public null|InlineKeyboardMarkup $reply_markup = null,
        
        /** @var InputMessageContent|null Optional. Content of the message to be sent instead of the video. This field is required if InlineQueryResultVideo is used to send an HTML-page as a result (e.g., a YouTube video). */
        public null|InputMessageContent $input_message_content = null,
        
        
    ) { }
}
