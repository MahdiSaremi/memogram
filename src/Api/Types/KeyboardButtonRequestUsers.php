<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class KeyboardButtonRequestUsers
{
    use Concerns\Data;

    public function __construct(
        /** @var int Signed 32-bit identifier of the request that will be received back in the UsersShared object. Must be unique within the message */
        public int $request_id,
        
        /** @var bool|null Optional. Pass True to request bots, pass False to request regular users. If not specified, no additional restrictions are applied. */
        public null|bool $user_is_bot = null,
        
        /** @var bool|null Optional. Pass True to request premium users, pass False to request non-premium users. If not specified, no additional restrictions are applied. */
        public null|bool $user_is_premium = null,
        
        /** @var int|null Optional. The maximum number of users to be selected; 1-10. Defaults to 1. */
        public null|int $max_quantity = null,
        
        /** @var bool|null Optional. Pass True to request the users' first and last names */
        public null|bool $request_name = null,
        
        /** @var bool|null Optional. Pass True to request the users' usernames */
        public null|bool $request_username = null,
        
        /** @var bool|null Optional. Pass True to request the users' photos */
        public null|bool $request_photo = null,
        
        
    ) { }
}
