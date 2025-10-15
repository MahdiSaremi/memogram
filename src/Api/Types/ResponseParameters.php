<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class ResponseParameters
{
    use Concerns\Data;

    public function __construct(
        /** @var int|null Optional. The group has been migrated to a supergroup with the specified identifier. This number may have more than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it. But it has at most 52 significant bits, so a signed 64-bit integer or double-precision float type are safe for storing this identifier. */
        public null|int $migrate_to_chat_id = null,
        
        /** @var int|null Optional. In case of exceeding flood control, the number of seconds left to wait before the request can be repeated */
        public null|int $retry_after = null,
        
        
    ) { }
}
