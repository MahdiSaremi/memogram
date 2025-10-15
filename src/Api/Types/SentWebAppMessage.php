<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class SentWebAppMessage
{
    use Concerns\Data;

    public function __construct(
        /** @var string|null Optional. Identifier of the sent inline message. Available only if there is an inline keyboard attached to the message. */
        public null|string $inline_message_id = null,
        
        
    ) { }
}
