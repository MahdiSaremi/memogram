<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;


abstract class ChatMember
{
    public static function makeDynamic(array $data): self
    {
        return match ($data['status']) {
            'creator' => ChatMemberOwner::makeFromArray($data),
            'administrator' => ChatMemberAdministrator::makeFromArray($data),
            'member' => ChatMemberMember::makeFromArray($data),
            'restricted' => ChatMemberRestricted::makeFromArray($data),
            'left' => ChatMemberLeft::makeFromArray($data),
            'kicked' => ChatMemberBanned::makeFromArray($data),
        };
    }

    public function isJoined(): bool
    {
        return $this instanceof ChatMemberOwner || $this instanceof ChatMemberAdministrator || $this instanceof ChatMemberMember;
    }
}
