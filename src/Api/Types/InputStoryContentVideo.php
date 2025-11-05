<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class InputStoryContentVideo extends InputStoryContent
{
    use Concerns\Data;

    /** @var string Type of the content, must be video */
    public string $type = 'video';

    public function __construct(
        /** @var string The video to post as a story. The video must be of the size 720x1280, streamable, encoded with H.265 codec, with key frames added each second in the MPEG4 format, and must not exceed 30 MB. The video can't be reused and can only be uploaded as a new file, so you can pass “attach://<file_attach_name>” if the video was uploaded using multipart/form-data under <file_attach_name>. More information on Sending Files » */
        public string $video,
        
        /** @var float|null Optional. Precise duration of the video in seconds; 0-60 */
        public null|float $duration = null,
        
        /** @var float|null Optional. Timestamp in seconds of the frame that will be used as the static cover for the story. Defaults to 0.0. */
        public null|float $cover_frame_timestamp = null,
        
        /** @var bool|null Optional. Pass True if the video has no sound */
        public null|bool $is_animation = null,
        
        
    ) { }
}
