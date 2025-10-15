<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class PassportElementErrorFiles
{
    use Concerns\Data;

    public function __construct(
        /** @var string Error source, must be files */
        public string $source,
        
        /** @var string The section of the user's Telegram Passport which has the issue, one of “utility_bill”, “bank_statement”, “rental_agreement”, “passport_registration”, “temporary_registration” */
        public string $type,
        
        /** @var array<\MemoGram\Api\Types\string> List of base64-encoded file hashes */
        public array $file_hashes,
        
        /** @var string Error message */
        public string $message,
        
        
    ) { }
}
