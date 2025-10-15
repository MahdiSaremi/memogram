<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class PassportElementErrorFrontSide
{
    use Concerns\Data;

    public function __construct(
        /** @var string Error source, must be front_side */
        public string $source,
        
        /** @var string The section of the user's Telegram Passport which has the issue, one of “passport”, “driver_license”, “identity_card”, “internal_passport” */
        public string $type,
        
        /** @var string Base64-encoded hash of the file with the front side of the document */
        public string $file_hash,
        
        /** @var string Error message */
        public string $message,
        
        
    ) { }
}
