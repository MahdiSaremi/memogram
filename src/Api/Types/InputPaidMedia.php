<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class InputPaidMedia
{
    use Concerns\Data;

    public function __construct(
        /** @var string Type of the media, must be photo */
        public string $type,
        
        /** @var string File to send. Pass a file_id to send a file that exists on the Telegram servers (recommended), pass an HTTP URL for Telegram to get a file from the Internet, or pass “attach://<file_attach_name>” to upload a new one using multipart/form-data under <file_attach_name> name. More information on Sending Files » */
        public string $media,
        
        
    ) { }
}
