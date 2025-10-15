<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class ForceReply
{
    use Concerns\Data;

    public function __construct(
        /** @var bool Shows reply interface to the user, as if they manually selected the bot's message and tapped 'Reply' */
        public bool $force_reply,
        
        /** @var string|null Optional. The placeholder to be shown in the input field when the reply is active; 1-64 characters */
        public null|string $input_field_placeholder = null,
        
        /** @var bool|null Optional. Use this parameter if you want to force reply from specific users only. Targets: 1) users that are @mentioned in the text of the Message object; 2) if the bot's message is a reply to a message in the same chat and forum topic, sender of the original message. */
        public null|bool $selective = null,
        
        
    ) { }
}
