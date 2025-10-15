<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class InputStoryContent
{
    use Concerns\Data;

    public function __construct(
        /** @var string Type of the content, must be photo */
        public string $type,
        
        /** @var string The photo to post as a story. The photo must be of the size 1080x1920 and must not exceed 10 MB. The photo can't be reused and can only be uploaded as a new file, so you can pass “attach://<file_attach_name>” if the photo was uploaded using multipart/form-data under <file_attach_name>. More information on Sending Files » */
        public string $photo,
        
        
    ) { }
}
