<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\User;


class CallbackQuery
{
    use Concerns\Data;

    public function __construct(
        /** @var string Unique identifier for this query */
        public string $id,
        
        /** @var User Sender */
        public User $from,
        
        /** @var InaccessibleMessage|Message|null Optional. Message sent by the bot with the callback button that originated the query */
        #[\MemoGram\Api\Attributes\_Choose("date", [[0, InaccessibleMessage::class], [null, Message::class]])]
        public null|InaccessibleMessage|Message $message = null,
        
        /** @var string|null Optional. Identifier of the message sent via the bot in inline mode, that originated the query. */
        public null|string $inline_message_id = null,
        
        /** @var string Global identifier, uniquely corresponding to the chat to which the message with the callback button was sent. Useful for high scores in games. */
        public string $chat_instance,
        
        /** @var string|null Optional. Data associated with the callback button. Be aware that the message originated the query can contain no callback buttons with this data. */
        public null|string $data = null,
        
        /** @var string|null Optional. Short name of a Game to be returned, serves as the unique identifier for the game */
        public null|string $game_short_name = null,
        
        
    ) { }
}
