<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class InputProfilePhotoAnimated
{
    use Concerns\Data;

    public function __construct(
        /** @var string Type of the profile photo, must be animated */
        public string $type,
        
        /** @var string The animated profile photo. Profile photos can't be reused and can only be uploaded as a new file, so you can pass “attach://<file_attach_name>” if the photo was uploaded using multipart/form-data under <file_attach_name>. More information on Sending Files » */
        public string $animation,
        
        /** @var float|null Optional. Timestamp in seconds of the frame that will be used as the static profile photo. Defaults to 0.0. */
        public null|float $main_frame_timestamp = null,
        
        
    ) { }
}
