<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class CallbackGame
{
    use Concerns\Data;

    public function __construct(
        /** @var int User identifier */
        public int $user_id,
        
        /** @var int New score, must be non-negative */
        public int $score,
        
        /** @var bool|null Pass True if the high score is allowed to decrease. This can be useful when fixing mistakes or banning cheaters */
        public null|bool $force = null,
        
        /** @var bool|null Pass True if the game message should not be automatically edited to include the current scoreboard */
        public null|bool $disable_edit_message = null,
        
        /** @var int|null Required if inline_message_id is not specified. Unique identifier for the target chat */
        public null|int $chat_id = null,
        
        /** @var int|null Required if inline_message_id is not specified. Identifier of the sent message */
        public null|int $message_id = null,
        
        /** @var string|null Required if chat_id and message_id are not specified. Identifier of the inline message */
        public null|string $inline_message_id = null,
        
        
    ) { }
}
