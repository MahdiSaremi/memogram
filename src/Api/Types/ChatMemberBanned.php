<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class ChatMemberBanned extends ChatMember
{
    use Concerns\Data;

    /** @var string The member's status in the chat, always “kicked” */
    public string $status = 'kicked';

    public function __construct(
        /** @var User Information about the user */
        public User   $user,

        /** @var int Date when restrictions will be lifted for this user; Unix time. If 0, then the user is banned forever */
        public int    $until_date,


    )
    {
    }
}
