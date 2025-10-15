<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class PassportElementErrorUnspecified
{
    use Concerns\Data;

    public function __construct(
        /** @var string Error source, must be unspecified */
        public string $source,
        
        /** @var string Type of element of the user's Telegram Passport which has the issue */
        public string $type,
        
        /** @var string Base64-encoded element hash */
        public string $element_hash,
        
        /** @var string Error message */
        public string $message,
        
        
    ) { }
}
