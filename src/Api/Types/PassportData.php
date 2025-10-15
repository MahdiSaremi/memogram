<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\EncryptedCredentials;


class PassportData
{
    use Concerns\Data;

    public function __construct(
        /** @var array<\MemoGram\Api\Types\EncryptedPassportElement> Array with information about documents and other Telegram Passport elements that was shared with the bot */
        public array $data,
        
        /** @var EncryptedCredentials Encrypted credentials required to decrypt the data */
        public EncryptedCredentials $credentials,
        
        
    ) { }
}
