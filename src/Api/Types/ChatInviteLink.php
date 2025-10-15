<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\User;


class ChatInviteLink
{
    use Concerns\Data;

    public function __construct(
        /** @var string The invite link. If the link was created by another chat administrator, then the second part of the link will be replaced with “…”. */
        public string $invite_link,
        
        /** @var User Creator of the link */
        public User $creator,
        
        /** @var bool True, if users joining the chat via the link need to be approved by chat administrators */
        public bool $creates_join_request,
        
        /** @var bool True, if the link is primary */
        public bool $is_primary,
        
        /** @var bool True, if the link is revoked */
        public bool $is_revoked,
        
        /** @var string|null Optional. Invite link name */
        public null|string $name = null,
        
        /** @var int|null Optional. Point in time (Unix timestamp) when the link will expire or has been expired */
        public null|int $expire_date = null,
        
        /** @var int|null Optional. The maximum number of users that can be members of the chat simultaneously after joining the chat via this invite link; 1-99999 */
        public null|int $member_limit = null,
        
        /** @var int|null Optional. Number of pending join requests created using this link */
        public null|int $pending_join_request_count = null,
        
        /** @var int|null Optional. The number of seconds the subscription will be active for before the next payment */
        public null|int $subscription_period = null,
        
        /** @var int|null Optional. The amount of Telegram Stars a user must pay initially and after each subsequent subscription period to be a member of the chat using the link */
        public null|int $subscription_price = null,
        
        
    ) { }
}
