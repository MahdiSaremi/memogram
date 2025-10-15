<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class ReplyParameters
{
    use Concerns\Data;

    public function __construct(
        /** @var int Identifier of the message that will be replied to in the current chat, or in the chat chat_id if it is specified */
        public int $message_id,
        
        /** @var int|string|null Optional. If the message to be replied to is from a different chat, unique identifier for the chat or username of the channel (in the format @channelusername). Not supported for messages sent on behalf of a business account and messages from channel direct messages chats. */
        public null|int $chat_id = null,
        
        /** @var bool|null Optional. Pass True if the message should be sent even if the specified message to be replied to is not found. Always False for replies in another chat or forum topic. Always True for messages sent on behalf of a business account. */
        public null|bool $allow_sending_without_reply = null,
        
        /** @var string|null Optional. Quoted part of the message to be replied to; 0-1024 characters after entities parsing. The quote must be an exact substring of the message to be replied to, including bold, italic, underline, strikethrough, spoiler, and custom_emoji entities. The message will fail to send if the quote isn't found in the original message. */
        public null|string $quote = null,
        
        /** @var string|null Optional. Mode for parsing entities in the quote. See formatting options for more details. */
        public null|string $quote_parse_mode = null,
        
        /** @var array<\MemoGram\Api\Types\MessageEntity>|null Optional. A JSON-serialized list of special entities that appear in the quote. It can be specified instead of quote_parse_mode. */
        public null|array $quote_entities = null,
        
        /** @var int|null Optional. Position of the quote in the original message in UTF-16 code units */
        public null|int $quote_position = null,
        
        /** @var int|null Optional. Identifier of the specific checklist task to be replied to */
        public null|int $checklist_task_id = null,
        
        
    ) { }
}
