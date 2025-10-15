<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class PassportElementErrorReverseSide
{
    use Concerns\Data;

    public function __construct(
        /** @var string Error source, must be reverse_side */
        public string $source,
        
        /** @var string The section of the user's Telegram Passport which has the issue, one of “driver_license”, “identity_card” */
        public string $type,
        
        /** @var string Base64-encoded hash of the file with the reverse side of the document */
        public string $file_hash,
        
        /** @var string Error message */
        public string $message,
        
        
    ) { }
}
