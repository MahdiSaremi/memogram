<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class PassportElementError
{
    use Concerns\Data;

    public function __construct(
        /** @var string Error source, must be data */
        public string $source,
        
        /** @var string The section of the user's Telegram Passport which has the error, one of “personal_details”, “passport”, “driver_license”, “identity_card”, “internal_passport”, “address” */
        public string $type,
        
        /** @var string Name of the data field which has the error */
        public string $field_name,
        
        /** @var string Base64-encoded data hash */
        public string $data_hash,
        
        /** @var string Error message */
        public string $message,
        
        
    ) { }
}
