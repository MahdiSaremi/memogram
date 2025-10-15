<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\PassportFile;


class EncryptedPassportElement
{
    use Concerns\Data;

    public function __construct(
        /** @var string Element type. One of “personal_details”, “passport”, “driver_license”, “identity_card”, “internal_passport”, “address”, “utility_bill”, “bank_statement”, “rental_agreement”, “passport_registration”, “temporary_registration”, “phone_number”, “email”. */
        public string $type,
        
        /** @var string|null Optional. Base64-encoded encrypted Telegram Passport element data provided by the user; available only for “personal_details”, “passport”, “driver_license”, “identity_card”, “internal_passport” and “address” types. Can be decrypted and verified using the accompanying EncryptedCredentials. */
        public null|string $data = null,
        
        /** @var string|null Optional. User's verified phone number; available only for “phone_number” type */
        public null|string $phone_number = null,
        
        /** @var string|null Optional. User's verified email address; available only for “email” type */
        public null|string $email = null,
        
        /** @var array<\MemoGram\Api\Types\PassportFile>|null Optional. Array of encrypted files with documents provided by the user; available only for “utility_bill”, “bank_statement”, “rental_agreement”, “passport_registration” and “temporary_registration” types. Files can be decrypted and verified using the accompanying EncryptedCredentials. */
        public null|array $files = null,
        
        /** @var PassportFile|null Optional. Encrypted file with the front side of the document, provided by the user; available only for “passport”, “driver_license”, “identity_card” and “internal_passport”. The file can be decrypted and verified using the accompanying EncryptedCredentials. */
        public null|PassportFile $front_side = null,
        
        /** @var PassportFile|null Optional. Encrypted file with the reverse side of the document, provided by the user; available only for “driver_license” and “identity_card”. The file can be decrypted and verified using the accompanying EncryptedCredentials. */
        public null|PassportFile $reverse_side = null,
        
        /** @var PassportFile|null Optional. Encrypted file with the selfie of the user holding a document, provided by the user; available if requested for “passport”, “driver_license”, “identity_card” and “internal_passport”. The file can be decrypted and verified using the accompanying EncryptedCredentials. */
        public null|PassportFile $selfie = null,
        
        /** @var array<\MemoGram\Api\Types\PassportFile>|null Optional. Array of encrypted files with translated versions of documents provided by the user; available if requested for “passport”, “driver_license”, “identity_card”, “internal_passport”, “utility_bill”, “bank_statement”, “rental_agreement”, “passport_registration” and “temporary_registration” types. Files can be decrypted and verified using the accompanying EncryptedCredentials. */
        public null|array $translation = null,
        
        /** @var string Base64-encoded element hash for using in PassportElementErrorUnspecified */
        public string $hash,
        
        
    ) { }
}
