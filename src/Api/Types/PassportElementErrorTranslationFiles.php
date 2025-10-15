<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class PassportElementErrorTranslationFiles
{
    use Concerns\Data;

    public function __construct(
        /** @var string Error source, must be translation_files */
        public string $source,
        
        /** @var string Type of element of the user's Telegram Passport which has the issue, one of “passport”, “driver_license”, “identity_card”, “internal_passport”, “utility_bill”, “bank_statement”, “rental_agreement”, “passport_registration”, “temporary_registration” */
        public string $type,
        
        /** @var array<\MemoGram\Api\Types\string> List of base64-encoded file hashes */
        public array $file_hashes,
        
        /** @var string Error message */
        public string $message,
        
        
    ) { }
}
