<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class Contact
{
    use Concerns\Data;

    public function __construct(
        /** @var string Contact's phone number */
        public string $phone_number,
        
        /** @var string Contact's first name */
        public string $first_name,
        
        /** @var string|null Optional. Contact's last name */
        public null|string $last_name = null,
        
        /** @var int|null Optional. Contact's user identifier in Telegram. This number may have more than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it. But it has at most 52 significant bits, so a 64-bit integer or double-precision float type are safe for storing this identifier. */
        public null|int $user_id = null,
        
        /** @var string|null Optional. Additional data about the contact in the form of a vCard */
        public null|string $vcard = null,
        
        
    ) { }
}
