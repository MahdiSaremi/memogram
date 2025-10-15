<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class PassportElementErrorTranslationFile
{
    use Concerns\Data;

    public function __construct(
        /** @var string Error source, must be translation_file */
        public string $source,
        
        /** @var string Type of element of the user's Telegram Passport which has the issue, one of “passport”, “driver_license”, “identity_card”, “internal_passport”, “utility_bill”, “bank_statement”, “rental_agreement”, “passport_registration”, “temporary_registration” */
        public string $type,
        
        /** @var string Base64-encoded file hash */
        public string $file_hash,
        
        /** @var string Error message */
        public string $message,
        
        
    ) { }
}
