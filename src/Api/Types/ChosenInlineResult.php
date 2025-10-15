<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\User;
use MemoGram\Api\Types\Location;


class ChosenInlineResult
{
    use Concerns\Data;

    public function __construct(
        /** @var string The unique identifier for the result that was chosen */
        public string $result_id,
        
        /** @var User The user that chose the result */
        public User $from,
        
        /** @var Location|null Optional. Sender location, only for bots that require user location */
        public null|Location $location = null,
        
        /** @var string|null Optional. Identifier of the sent inline message. Available only if there is an inline keyboard attached to the message. Will be also received in callback queries and can be used to edit the message. */
        public null|string $inline_message_id = null,
        
        /** @var string The query that was used to obtain the result */
        public string $query,
        
        
    ) { }
}
