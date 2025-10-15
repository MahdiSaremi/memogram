<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class VideoChatParticipantsInvited
{
    use Concerns\Data;

    public function __construct(
        /** @var array<\MemoGram\Api\Types\User> New members that were invited to the video chat */
        public array $users,
        
        
    ) { }
}
