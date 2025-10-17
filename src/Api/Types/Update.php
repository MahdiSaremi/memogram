<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Handle\Event;
use MemoGram\Api\Types\Message;
use MemoGram\Api\Types\BusinessConnection;
use MemoGram\Api\Types\BusinessMessagesDeleted;
use MemoGram\Api\Types\MessageReactionUpdated;
use MemoGram\Api\Types\MessageReactionCountUpdated;
use MemoGram\Api\Types\InlineQuery;
use MemoGram\Api\Types\ChosenInlineResult;
use MemoGram\Api\Types\CallbackQuery;
use MemoGram\Api\Types\ShippingQuery;
use MemoGram\Api\Types\PreCheckoutQuery;
use MemoGram\Api\Types\PaidMediaPurchased;
use MemoGram\Api\Types\Poll;
use MemoGram\Api\Types\PollAnswer;
use MemoGram\Api\Types\ChatMemberUpdated;
use MemoGram\Api\Types\ChatJoinRequest;
use MemoGram\Api\Types\ChatBoostUpdated;
use MemoGram\Api\Types\ChatBoostRemoved;


class Update implements Event
{
    use Concerns\Data;

    public function __construct(
        /** @var int The update's unique identifier. Update identifiers start from a certain positive number and increase sequentially. This identifier becomes especially handy if you're using webhooks, since it allows you to ignore repeated updates or to restore the correct update sequence, should they get out of order. If there are no new updates for at least a week, then identifier of the next update will be chosen randomly instead of sequentially. */
        public int $update_id,
        
        /** @var Message|null Optional. New incoming message of any kind - text, photo, sticker, etc. */
        public null|Message $message = null,
        
        /** @var Message|null Optional. New version of a message that is known to the bot and was edited. This update may at times be triggered by changes to message fields that are either unavailable or not actively used by your bot. */
        public null|Message $edited_message = null,
        
        /** @var Message|null Optional. New incoming channel post of any kind - text, photo, sticker, etc. */
        public null|Message $channel_post = null,
        
        /** @var Message|null Optional. New version of a channel post that is known to the bot and was edited. This update may at times be triggered by changes to message fields that are either unavailable or not actively used by your bot. */
        public null|Message $edited_channel_post = null,
        
        /** @var BusinessConnection|null Optional. The bot was connected to or disconnected from a business account, or a user edited an existing connection with the bot */
        public null|BusinessConnection $business_connection = null,
        
        /** @var Message|null Optional. New message from a connected business account */
        public null|Message $business_message = null,
        
        /** @var Message|null Optional. New version of a message from a connected business account */
        public null|Message $edited_business_message = null,
        
        /** @var BusinessMessagesDeleted|null Optional. Messages were deleted from a connected business account */
        public null|BusinessMessagesDeleted $deleted_business_messages = null,
        
        /** @var MessageReactionUpdated|null Optional. A reaction to a message was changed by a user. The bot must be an administrator in the chat and must explicitly specify "message_reaction" in the list of allowed_updates to receive these updates. The update isn't received for reactions set by bots. */
        public null|MessageReactionUpdated $message_reaction = null,
        
        /** @var MessageReactionCountUpdated|null Optional. Reactions to a message with anonymous reactions were changed. The bot must be an administrator in the chat and must explicitly specify "message_reaction_count" in the list of allowed_updates to receive these updates. The updates are grouped and can be sent with delay up to a few minutes. */
        public null|MessageReactionCountUpdated $message_reaction_count = null,
        
        /** @var InlineQuery|null Optional. New incoming inline query */
        public null|InlineQuery $inline_query = null,
        
        /** @var ChosenInlineResult|null Optional. The result of an inline query that was chosen by a user and sent to their chat partner. Please see our documentation on the feedback collecting for details on how to enable these updates for your bot. */
        public null|ChosenInlineResult $chosen_inline_result = null,
        
        /** @var CallbackQuery|null Optional. New incoming callback query */
        public null|CallbackQuery $callback_query = null,
        
        /** @var ShippingQuery|null Optional. New incoming shipping query. Only for invoices with flexible price */
        public null|ShippingQuery $shipping_query = null,
        
        /** @var PreCheckoutQuery|null Optional. New incoming pre-checkout query. Contains full information about checkout */
        public null|PreCheckoutQuery $pre_checkout_query = null,
        
        /** @var PaidMediaPurchased|null Optional. A user purchased paid media with a non-empty payload sent by the bot in a non-channel chat */
        public null|PaidMediaPurchased $purchased_paid_media = null,
        
        /** @var Poll|null Optional. New poll state. Bots receive only updates about manually stopped polls and polls, which are sent by the bot */
        public null|Poll $poll = null,
        
        /** @var PollAnswer|null Optional. A user changed their answer in a non-anonymous poll. Bots receive new votes only in polls that were sent by the bot itself. */
        public null|PollAnswer $poll_answer = null,
        
        /** @var ChatMemberUpdated|null Optional. The bot's chat member status was updated in a chat. For private chats, this update is received only when the bot is blocked or unblocked by the user. */
        public null|ChatMemberUpdated $my_chat_member = null,
        
        /** @var ChatMemberUpdated|null Optional. A chat member's status was updated in a chat. The bot must be an administrator in the chat and must explicitly specify "chat_member" in the list of allowed_updates to receive these updates. */
        public null|ChatMemberUpdated $chat_member = null,
        
        /** @var ChatJoinRequest|null Optional. A request to join the chat has been sent. The bot must have the can_invite_users administrator right in the chat to receive these updates. */
        public null|ChatJoinRequest $chat_join_request = null,
        
        /** @var ChatBoostUpdated|null Optional. A chat boost was added or changed. The bot must be an administrator in the chat to receive these updates. */
        public null|ChatBoostUpdated $chat_boost = null,
        
        /** @var ChatBoostRemoved|null Optional. A boost was removed from a chat. The bot must be an administrator in the chat to receive these updates. */
        public null|ChatBoostRemoved $removed_chat_boost = null,
        
        
    ) { }

    public function getChatId(): null|string|int
    {
        return $this->message?->chat?->id
            ?? $this->edited_message?->chat?->id
            ?? $this->channel_post?->chat?->id
            ?? $this->edited_channel_post?->chat?->id
            ?? $this->callback_query?->message?->chat?->id // todo
            ?? $this->message_reaction?->chat?->id
            ?? $this->chat_boost?->chat?->id
            ?? $this->chat_join_request?->chat?->id
            ?? $this->removed_chat_boost?->chat?->id
            ?? $this->chat_member?->chat?->id
            ?? $this->my_chat_member?->chat?->id;
    }

    public function getUserId(): null|string|int
    {
        return $this->message?->from?->id
            ?? $this->edited_message?->from?->id
            ?? $this->callback_query?->from?->id
            ?? $this->message_reaction?->user?->id
            ?? $this->chat_join_request?->from?->id
            ?? $this->chat_member?->from?->id
            ?? $this->my_chat_member?->from?->id
            ?? $this->inline_query?->from?->id
            ?? $this->chosen_inline_result?->from?->id;
    }

    public function getUserMessageId(): null|string|int
    {
        return $this->message?->message_id
            ?? $this->edited_message?->message_id
            ?? $this->channel_post?->message_id
            ?? $this->edited_channel_post?->message_id
            ?? $this->callback_query?->message?->message_id // todo
            ?? $this->callback_query?->inline_message_id
            ?? $this->message_reaction?->message_id;
    }

    public function getInteractionMessageId(): null|string|int
    {
        return $this->callback_query?->message?->message_id
            ?? $this->callback_query?->inline_message_id;
    }

    public function getInteractionRepliedMessageId(): null|string|int
    {
        return $this->message?->reply_to_message?->message_id;
    }
}
