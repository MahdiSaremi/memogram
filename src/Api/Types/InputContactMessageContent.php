<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class InputContactMessageContent
{
    use Concerns\Data;

    public function __construct(
        /** @var string Contact's phone number */
        public string $phone_number,
        
        /** @var string Contact's first name */
        public string $first_name,
        
        /** @var string|null Optional. Contact's last name */
        public null|string $last_name = null,
        
        /** @var string|null Optional. Additional data about the contact in the form of a vCard, 0-2048 bytes */
        public null|string $vcard = null,
        
        
    ) { }
}
