<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class PreparedInlineMessage
{
    use Concerns\Data;

    public function __construct(
        /** @var string Unique identifier of the prepared message */
        public string $id,
        
        /** @var int Expiration date of the prepared message, in Unix time. Expired prepared messages can no longer be used */
        public int $expiration_date,
        
        
    ) { }
}
