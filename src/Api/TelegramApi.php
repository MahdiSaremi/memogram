<?php

declare(strict_types=1);

namespace MemoGram\Api;

use MemoGram\Api\Types\AcceptedGiftTypes;
use MemoGram\Api\Types\BotCommand;
use MemoGram\Api\Types\BotCommandScope;
use MemoGram\Api\Types\BotDescription;
use MemoGram\Api\Types\BotName;
use MemoGram\Api\Types\BotShortDescription;
use MemoGram\Api\Types\BusinessConnection;
use MemoGram\Api\Types\ChatAdministratorRights;
use MemoGram\Api\Types\ChatFullInfo;
use MemoGram\Api\Types\ChatInviteLink;
use MemoGram\Api\Types\ChatMember;
use MemoGram\Api\Types\ChatPermissions;
use MemoGram\Api\Types\File;
use MemoGram\Api\Types\ForceReply;
use MemoGram\Api\Types\ForumTopic;
use MemoGram\Api\Types\GameHighScore;
use MemoGram\Api\Types\InlineKeyboardMarkup;
use MemoGram\Api\Types\InlineQueryResult;
use MemoGram\Api\Types\InlineQueryResultsButton;
use MemoGram\Api\Types\InputChecklist;
use MemoGram\Api\Types\InputMedia;
use MemoGram\Api\Types\InputMediaAnimation;
use MemoGram\Api\Types\InputMediaAudio;
use MemoGram\Api\Types\InputMediaDocument;
use MemoGram\Api\Types\InputMediaPhoto;
use MemoGram\Api\Types\InputMediaVideo;
use MemoGram\Api\Types\InputProfilePhoto;
use MemoGram\Api\Types\InputSticker;
use MemoGram\Api\Types\InputStoryContent;
use MemoGram\Api\Types\LinkPreviewOptions;
use MemoGram\Api\Types\MaskPosition;
use MemoGram\Api\Types\MenuButton;
use MemoGram\Api\Types\Message;
use MemoGram\Api\Types\PreparedInlineMessage;
use MemoGram\Api\Types\ReplyKeyboardMarkup;
use MemoGram\Api\Types\ReplyKeyboardRemove;
use MemoGram\Api\Types\ReplyParameters;
use MemoGram\Api\Types\Sticker;
use MemoGram\Api\Types\Story;
use MemoGram\Api\Types\SuggestedPostParameters;
use MemoGram\Api\Types\Update;
use MemoGram\Api\Types\UserChatBoosts;
use MemoGram\Api\Types\UserProfilePhotos;


class TelegramApi
{
    use Concerns\Requests;

    public function __construct(
        private readonly string $token,
    )
    {
    }

    /**
     * A JSON-serialized list of the update types you want your bot to receive. For example, specify ["message", "edited_channel_post", "callback_query"] to only receive updates of these types. See Update for a complete list of available update types. Specify an empty list to receive all update types except chat_member, message_reaction, and message_reaction_count (default). If not specified, the previous setting will be used.Please note that this parameter doesn't affect updates created before the call to getUpdates, so unwanted updates may be received for a short period of time.
     * @param int|null $offset Identifier of the first update to be returned. Must be greater by one than the highest among the identifiers of previously received updates. By default, updates starting with the earliest unconfirmed update are returned. An update is considered confirmed as soon as getUpdates is called with an offset higher than its update_id. The negative offset can be specified to retrieve updates starting from -offset update from the end of the updates queue. All previous updates will be forgotten.
     * @param int|null $limit Limits the number of updates to be retrieved. Values between 1-100 are accepted. Defaults to 100.
     * @param int|null $timeout Timeout in seconds for long polling. Defaults to 0, i.e. usual short polling. Should be positive, short polling should be used for testing purposes only.
     * @param array<\MemoGram\Api\Types\string>|null $allowed_updates A JSON-serialized list of the update types you want your bot to receive. For example, specify ["message", "edited_channel_post", "callback_query"] to only receive updates of these types. See Update for a complete list of available update types. Specify an empty list to receive all update types except chat_member, message_reaction, and message_reaction_count (default). If not specified, the previous setting will be used.Please note that this parameter doesn't affect updates created before the call to getUpdates, so unwanted updates may be received for a short period of time.
     * @return array<Update>|null
     */
    public function getUpdates(?int $offset = null, ?int $limit = null, ?int $timeout = null, ?array $allowed_updates = null, ...$args): array|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('getUpdates', $vars), ['array', Update::class]);
    }

    /**
     * A secret token to be sent in a header “X-Telegram-Bot-Api-Secret-Token” in every webhook request, 1-256 characters. Only characters A-Z, a-z, 0-9, _ and - are allowed. The header is useful to ensure that the request comes from a webhook set by you.
     * @param string $url HTTPS URL to send updates to. Use an empty string to remove webhook integration
     * @param mixed|null $certificate Upload your public key certificate so that the root certificate in use can be checked. See our self-signed guide for details.
     * @param string|null $ip_address The fixed IP address which will be used to send webhook requests instead of the IP address resolved through DNS
     * @param int|null $max_connections The maximum allowed number of simultaneous HTTPS connections to the webhook for update delivery, 1-100. Defaults to 40. Use lower values to limit the load on your bot's server, and higher values to increase your bot's throughput.
     * @param array<\MemoGram\Api\Types\string>|null $allowed_updates A JSON-serialized list of the update types you want your bot to receive. For example, specify ["message", "edited_channel_post", "callback_query"] to only receive updates of these types. See Update for a complete list of available update types. Specify an empty list to receive all update types except chat_member, message_reaction, and message_reaction_count (default). If not specified, the previous setting will be used.Please note that this parameter doesn't affect updates created before the call to the setWebhook, so unwanted updates may be received for a short period of time.
     * @param bool|null $drop_pending_updates Pass True to drop all pending updates
     * @param string|null $secret_token A secret token to be sent in a header “X-Telegram-Bot-Api-Secret-Token” in every webhook request, 1-256 characters. Only characters A-Z, a-z, 0-9, _ and - are allowed. The header is useful to ensure that the request comes from a webhook set by you.
     * @return true|null
     */
    public function setWebhook(string $url, mixed $certificate = null, ?string $ip_address = null, ?int $max_connections = null, ?array $allowed_updates = null, ?bool $drop_pending_updates = null, ?string $secret_token = null, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('setWebhook', $vars), ['true']);
    }

    /**
     * Pass True to drop all pending updates
     * @param bool|null $drop_pending_updates Pass True to drop all pending updates
     * @return true|null
     */
    public function deleteWebhook(?bool $drop_pending_updates = null, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('deleteWebhook', $vars), ['true']);
    }

    /**
     * Optional. A list of update types the bot is subscribed to. Defaults to all update types except chat_member
     * @param string $url Webhook URL, may be empty if webhook is not set up
     * @param bool $has_custom_certificate True, if a custom certificate was provided for webhook certificate checks
     * @param int $pending_update_count Number of updates awaiting delivery
     * @param string|null $ip_address Optional. Currently used webhook IP address
     * @param int|null $last_error_date Optional. Unix time for the most recent error that happened when trying to deliver an update via webhook
     * @param string|null $last_error_message Optional. Error message in human-readable format for the most recent error that happened when trying to deliver an update via webhook
     * @param int|null $last_synchronization_error_date Optional. Unix time of the most recent error that happened when trying to synchronize available updates with Telegram datacenters
     * @param int|null $max_connections Optional. The maximum allowed number of simultaneous HTTPS connections to the webhook for update delivery
     * @param array<\MemoGram\Api\Types\string>|null $allowed_updates Optional. A list of update types the bot is subscribed to. Defaults to all update types except chat_member
     * @return mixed
     */
    public function getWebhookInfo(string $url, bool $has_custom_certificate, int $pending_update_count, ?string $ip_address = null, ?int $last_error_date = null, ?string $last_error_message = null, ?int $last_synchronization_error_date = null, ?int $max_connections = null, ?array $allowed_updates = null, ...$args): mixed
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('getWebhookInfo', $vars), ['mixed']);
    }

    /**
     * Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param string $text Text of the message to be sent, 1-4096 characters after entities parsing
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param int|null $direct_messages_topic_id Identifier of the direct messages topic to which the message will be sent; required if the message is sent to a direct messages chat
     * @param string|null $parse_mode Mode for parsing entities in the message text. See formatting options for more details.
     * @param array<\MemoGram\Api\Types\MessageEntity>|null $entities A JSON-serialized list of special entities that appear in message text, which can be specified instead of parse_mode
     * @param LinkPreviewOptions|null $link_preview_options Link preview generation options for the message
     * @param bool|null $disable_notification Sends the message silently. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param bool|null $allow_paid_broadcast Pass True to allow up to 1000 messages per second, ignoring broadcasting limits for a fee of 0.1 Telegram Stars per message. The relevant Stars will be withdrawn from the bot's balance
     * @param string|null $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param SuggestedPostParameters|null $suggested_post_parameters A JSON-serialized object containing the parameters of the suggested post to send; for direct messages chats only. If the message is sent as a reply to another suggested post, then that suggested post is automatically declined.
     * @param ReplyParameters|null $reply_parameters Description of the message to reply to
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
     * @return Message|null
     */
    public function getMe(int|string $chat_id, string $text, ?string $business_connection_id = null, ?int $message_thread_id = null, ?int $direct_messages_topic_id = null, ?string $parse_mode = null, ?array $entities = null, ?LinkPreviewOptions $link_preview_options = null, ?bool $disable_notification = null, ?bool $protect_content = null, ?bool $allow_paid_broadcast = null, ?string $message_effect_id = null, ?SuggestedPostParameters $suggested_post_parameters = null, ?ReplyParameters $reply_parameters = null, InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null, ...$args): Message|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('getMe', $vars), [Message::class]);
    }

    /**
     * Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param string $text Text of the message to be sent, 1-4096 characters after entities parsing
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param int|null $direct_messages_topic_id Identifier of the direct messages topic to which the message will be sent; required if the message is sent to a direct messages chat
     * @param string|null $parse_mode Mode for parsing entities in the message text. See formatting options for more details.
     * @param array<\MemoGram\Api\Types\MessageEntity>|null $entities A JSON-serialized list of special entities that appear in message text, which can be specified instead of parse_mode
     * @param LinkPreviewOptions|null $link_preview_options Link preview generation options for the message
     * @param bool|null $disable_notification Sends the message silently. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param bool|null $allow_paid_broadcast Pass True to allow up to 1000 messages per second, ignoring broadcasting limits for a fee of 0.1 Telegram Stars per message. The relevant Stars will be withdrawn from the bot's balance
     * @param string|null $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param SuggestedPostParameters|null $suggested_post_parameters A JSON-serialized object containing the parameters of the suggested post to send; for direct messages chats only. If the message is sent as a reply to another suggested post, then that suggested post is automatically declined.
     * @param ReplyParameters|null $reply_parameters Description of the message to reply to
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
     * @return Message|null
     */
    public function logOut(int|string $chat_id, string $text, ?string $business_connection_id = null, ?int $message_thread_id = null, ?int $direct_messages_topic_id = null, ?string $parse_mode = null, ?array $entities = null, ?LinkPreviewOptions $link_preview_options = null, ?bool $disable_notification = null, ?bool $protect_content = null, ?bool $allow_paid_broadcast = null, ?string $message_effect_id = null, ?SuggestedPostParameters $suggested_post_parameters = null, ?ReplyParameters $reply_parameters = null, InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null, ...$args): Message|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('logOut', $vars), [Message::class]);
    }

    /**
     * Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param string $text Text of the message to be sent, 1-4096 characters after entities parsing
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param int|null $direct_messages_topic_id Identifier of the direct messages topic to which the message will be sent; required if the message is sent to a direct messages chat
     * @param string|null $parse_mode Mode for parsing entities in the message text. See formatting options for more details.
     * @param array<\MemoGram\Api\Types\MessageEntity>|null $entities A JSON-serialized list of special entities that appear in message text, which can be specified instead of parse_mode
     * @param LinkPreviewOptions|null $link_preview_options Link preview generation options for the message
     * @param bool|null $disable_notification Sends the message silently. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param bool|null $allow_paid_broadcast Pass True to allow up to 1000 messages per second, ignoring broadcasting limits for a fee of 0.1 Telegram Stars per message. The relevant Stars will be withdrawn from the bot's balance
     * @param string|null $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param SuggestedPostParameters|null $suggested_post_parameters A JSON-serialized object containing the parameters of the suggested post to send; for direct messages chats only. If the message is sent as a reply to another suggested post, then that suggested post is automatically declined.
     * @param ReplyParameters|null $reply_parameters Description of the message to reply to
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
     * @return Message|null
     */
    public function close(int|string $chat_id, string $text, ?string $business_connection_id = null, ?int $message_thread_id = null, ?int $direct_messages_topic_id = null, ?string $parse_mode = null, ?array $entities = null, ?LinkPreviewOptions $link_preview_options = null, ?bool $disable_notification = null, ?bool $protect_content = null, ?bool $allow_paid_broadcast = null, ?string $message_effect_id = null, ?SuggestedPostParameters $suggested_post_parameters = null, ?ReplyParameters $reply_parameters = null, InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null, ...$args): Message|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('close', $vars), [Message::class]);
    }

    /**
     * Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param string $text Text of the message to be sent, 1-4096 characters after entities parsing
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param int|null $direct_messages_topic_id Identifier of the direct messages topic to which the message will be sent; required if the message is sent to a direct messages chat
     * @param string|null $parse_mode Mode for parsing entities in the message text. See formatting options for more details.
     * @param array<\MemoGram\Api\Types\MessageEntity>|null $entities A JSON-serialized list of special entities that appear in message text, which can be specified instead of parse_mode
     * @param LinkPreviewOptions|null $link_preview_options Link preview generation options for the message
     * @param bool|null $disable_notification Sends the message silently. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param bool|null $allow_paid_broadcast Pass True to allow up to 1000 messages per second, ignoring broadcasting limits for a fee of 0.1 Telegram Stars per message. The relevant Stars will be withdrawn from the bot's balance
     * @param string|null $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param SuggestedPostParameters|null $suggested_post_parameters A JSON-serialized object containing the parameters of the suggested post to send; for direct messages chats only. If the message is sent as a reply to another suggested post, then that suggested post is automatically declined.
     * @param ReplyParameters|null $reply_parameters Description of the message to reply to
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
     * @return Message|null
     */
    public function sendMessage(int|string $chat_id, string $text, ?string $business_connection_id = null, ?int $message_thread_id = null, ?int $direct_messages_topic_id = null, ?string $parse_mode = null, ?array $entities = null, ?LinkPreviewOptions $link_preview_options = null, ?bool $disable_notification = null, ?bool $protect_content = null, ?bool $allow_paid_broadcast = null, ?string $message_effect_id = null, ?SuggestedPostParameters $suggested_post_parameters = null, ?ReplyParameters $reply_parameters = null, InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null, ...$args): Message|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('sendMessage', $vars), [Message::class]);
    }

    /**
     * Message identifier in the chat specified in from_chat_id
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param int|string $from_chat_id Unique identifier for the chat where the original message was sent (or channel username in the format @channelusername)
     * @param int $message_id Message identifier in the chat specified in from_chat_id
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param int|null $direct_messages_topic_id Identifier of the direct messages topic to which the message will be forwarded; required if the message is forwarded to a direct messages chat
     * @param int|null $video_start_timestamp New start timestamp for the forwarded video in the message
     * @param bool|null $disable_notification Sends the message silently. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the forwarded message from forwarding and saving
     * @param SuggestedPostParameters|null $suggested_post_parameters A JSON-serialized object containing the parameters of the suggested post to send; for direct messages chats only
     * @return Message|null
     */
    public function forwardMessage(int|string $chat_id, int|string $from_chat_id, int $message_id, ?int $message_thread_id = null, ?int $direct_messages_topic_id = null, ?int $video_start_timestamp = null, ?bool $disable_notification = null, ?bool $protect_content = null, ?SuggestedPostParameters $suggested_post_parameters = null, ...$args): Message|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('forwardMessage', $vars), [Message::class]);
    }

    /**
     * Protects the contents of the forwarded messages from forwarding and saving
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param int|string $from_chat_id Unique identifier for the chat where the original messages were sent (or channel username in the format @channelusername)
     * @param array<\MemoGram\Api\Types\int> $message_ids A JSON-serialized list of 1-100 identifiers of messages in the chat from_chat_id to forward. The identifiers must be specified in a strictly increasing order.
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param int|null $direct_messages_topic_id Identifier of the direct messages topic to which the messages will be forwarded; required if the messages are forwarded to a direct messages chat
     * @param bool|null $disable_notification Sends the messages silently. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the forwarded messages from forwarding and saving
     * @return messages|null
     */
    public function forwardMessages(int|string $chat_id, int|string $from_chat_id, array $message_ids, ?int $message_thread_id = null, ?int $direct_messages_topic_id = null, ?bool $disable_notification = null, ?bool $protect_content = null, ...$args): messages|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('forwardMessages', $vars), ['messages']);
    }

    /**
     * Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param int|string $from_chat_id Unique identifier for the chat where the original message was sent (or channel username in the format @channelusername)
     * @param int $message_id Message identifier in the chat specified in from_chat_id
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param int|null $direct_messages_topic_id Identifier of the direct messages topic to which the message will be sent; required if the message is sent to a direct messages chat
     * @param int|null $video_start_timestamp New start timestamp for the copied video in the message
     * @param string|null $caption New caption for media, 0-1024 characters after entities parsing. If not specified, the original caption is kept
     * @param string|null $parse_mode Mode for parsing entities in the new caption. See formatting options for more details.
     * @param array<\MemoGram\Api\Types\MessageEntity>|null $caption_entities A JSON-serialized list of special entities that appear in the new caption, which can be specified instead of parse_mode
     * @param bool|null $show_caption_above_media Pass True, if the caption must be shown above the message media. Ignored if a new caption isn't specified.
     * @param bool|null $disable_notification Sends the message silently. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param bool|null $allow_paid_broadcast Pass True to allow up to 1000 messages per second, ignoring broadcasting limits for a fee of 0.1 Telegram Stars per message. The relevant Stars will be withdrawn from the bot's balance
     * @param SuggestedPostParameters|null $suggested_post_parameters A JSON-serialized object containing the parameters of the suggested post to send; for direct messages chats only. If the message is sent as a reply to another suggested post, then that suggested post is automatically declined.
     * @param ReplyParameters|null $reply_parameters Description of the message to reply to
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
     * @return int|null
     */
    public function copyMessage(int|string $chat_id, int|string $from_chat_id, int $message_id, ?int $message_thread_id = null, ?int $direct_messages_topic_id = null, ?int $video_start_timestamp = null, ?string $caption = null, ?string $parse_mode = null, ?array $caption_entities = null, ?bool $show_caption_above_media = null, ?bool $disable_notification = null, ?bool $protect_content = null, ?bool $allow_paid_broadcast = null, ?SuggestedPostParameters $suggested_post_parameters = null, ?ReplyParameters $reply_parameters = null, InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null, ...$args): int|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('copyMessage', $vars), ['int']);
    }

    /**
     * Pass True to copy the messages without their captions
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param int|string $from_chat_id Unique identifier for the chat where the original messages were sent (or channel username in the format @channelusername)
     * @param array<\MemoGram\Api\Types\int> $message_ids A JSON-serialized list of 1-100 identifiers of messages in the chat from_chat_id to copy. The identifiers must be specified in a strictly increasing order.
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param int|null $direct_messages_topic_id Identifier of the direct messages topic to which the messages will be sent; required if the messages are sent to a direct messages chat
     * @param bool|null $disable_notification Sends the messages silently. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent messages from forwarding and saving
     * @param bool|null $remove_caption Pass True to copy the messages without their captions
     * @return messages|null
     */
    public function copyMessages(int|string $chat_id, int|string $from_chat_id, array $message_ids, ?int $message_thread_id = null, ?int $direct_messages_topic_id = null, ?bool $disable_notification = null, ?bool $protect_content = null, ?bool $remove_caption = null, ...$args): messages|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('copyMessages', $vars), ['messages']);
    }

    /**
     * Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param mixed|string $photo Photo to send. Pass a file_id as String to send a photo that exists on the Telegram servers (recommended), pass an HTTP URL as a String for Telegram to get a photo from the Internet, or upload a new photo using multipart/form-data. The photo must be at most 10 MB in size. The photo's width and height must not exceed 10000 in total. Width and height ratio must be at most 20. More information on Sending Files »
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param int|null $direct_messages_topic_id Identifier of the direct messages topic to which the message will be sent; required if the message is sent to a direct messages chat
     * @param string|null $caption Photo caption (may also be used when resending photos by file_id), 0-1024 characters after entities parsing
     * @param string|null $parse_mode Mode for parsing entities in the photo caption. See formatting options for more details.
     * @param array<\MemoGram\Api\Types\MessageEntity>|null $caption_entities A JSON-serialized list of special entities that appear in the caption, which can be specified instead of parse_mode
     * @param bool|null $show_caption_above_media Pass True, if the caption must be shown above the message media
     * @param bool|null $has_spoiler Pass True if the photo needs to be covered with a spoiler animation
     * @param bool|null $disable_notification Sends the message silently. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param bool|null $allow_paid_broadcast Pass True to allow up to 1000 messages per second, ignoring broadcasting limits for a fee of 0.1 Telegram Stars per message. The relevant Stars will be withdrawn from the bot's balance
     * @param string|null $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param SuggestedPostParameters|null $suggested_post_parameters A JSON-serialized object containing the parameters of the suggested post to send; for direct messages chats only. If the message is sent as a reply to another suggested post, then that suggested post is automatically declined.
     * @param ReplyParameters|null $reply_parameters Description of the message to reply to
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
     * @return Message|null
     */
    public function sendPhoto(int|string $chat_id, mixed $photo, ?string $business_connection_id = null, ?int $message_thread_id = null, ?int $direct_messages_topic_id = null, ?string $caption = null, ?string $parse_mode = null, ?array $caption_entities = null, ?bool $show_caption_above_media = null, ?bool $has_spoiler = null, ?bool $disable_notification = null, ?bool $protect_content = null, ?bool $allow_paid_broadcast = null, ?string $message_effect_id = null, ?SuggestedPostParameters $suggested_post_parameters = null, ?ReplyParameters $reply_parameters = null, InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null, ...$args): Message|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('sendPhoto', $vars), [Message::class]);
    }

    /**
     * Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param mixed|string $audio Audio file to send. Pass a file_id as String to send an audio file that exists on the Telegram servers (recommended), pass an HTTP URL as a String for Telegram to get an audio file from the Internet, or upload a new one using multipart/form-data. More information on Sending Files »
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param int|null $direct_messages_topic_id Identifier of the direct messages topic to which the message will be sent; required if the message is sent to a direct messages chat
     * @param string|null $caption Audio caption, 0-1024 characters after entities parsing
     * @param string|null $parse_mode Mode for parsing entities in the audio caption. See formatting options for more details.
     * @param array<\MemoGram\Api\Types\MessageEntity>|null $caption_entities A JSON-serialized list of special entities that appear in the caption, which can be specified instead of parse_mode
     * @param int|null $duration Duration of the audio in seconds
     * @param string|null $performer Performer
     * @param string|null $title Track name
     * @param mixed|string|null $thumbnail Thumbnail of the file sent; can be ignored if thumbnail generation for the file is supported server-side. The thumbnail should be in JPEG format and less than 200 kB in size. A thumbnail's width and height should not exceed 320. Ignored if the file is not uploaded using multipart/form-data. Thumbnails can't be reused and can be only uploaded as a new file, so you can pass “attach://<file_attach_name>” if the thumbnail was uploaded using multipart/form-data under <file_attach_name>. More information on Sending Files »
     * @param bool|null $disable_notification Sends the message silently. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param bool|null $allow_paid_broadcast Pass True to allow up to 1000 messages per second, ignoring broadcasting limits for a fee of 0.1 Telegram Stars per message. The relevant Stars will be withdrawn from the bot's balance
     * @param string|null $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param SuggestedPostParameters|null $suggested_post_parameters A JSON-serialized object containing the parameters of the suggested post to send; for direct messages chats only. If the message is sent as a reply to another suggested post, then that suggested post is automatically declined.
     * @param ReplyParameters|null $reply_parameters Description of the message to reply to
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
     * @return Message|null
     */
    public function sendAudio(int|string $chat_id, mixed $audio, ?string $business_connection_id = null, ?int $message_thread_id = null, ?int $direct_messages_topic_id = null, ?string $caption = null, ?string $parse_mode = null, ?array $caption_entities = null, ?int $duration = null, ?string $performer = null, ?string $title = null, mixed $thumbnail = null, ?bool $disable_notification = null, ?bool $protect_content = null, ?bool $allow_paid_broadcast = null, ?string $message_effect_id = null, ?SuggestedPostParameters $suggested_post_parameters = null, ?ReplyParameters $reply_parameters = null, InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null, ...$args): Message|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('sendAudio', $vars), [Message::class]);
    }

    /**
     * Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param mixed|string $document File to send. Pass a file_id as String to send a file that exists on the Telegram servers (recommended), pass an HTTP URL as a String for Telegram to get a file from the Internet, or upload a new one using multipart/form-data. More information on Sending Files »
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param int|null $direct_messages_topic_id Identifier of the direct messages topic to which the message will be sent; required if the message is sent to a direct messages chat
     * @param mixed|string|null $thumbnail Thumbnail of the file sent; can be ignored if thumbnail generation for the file is supported server-side. The thumbnail should be in JPEG format and less than 200 kB in size. A thumbnail's width and height should not exceed 320. Ignored if the file is not uploaded using multipart/form-data. Thumbnails can't be reused and can be only uploaded as a new file, so you can pass “attach://<file_attach_name>” if the thumbnail was uploaded using multipart/form-data under <file_attach_name>. More information on Sending Files »
     * @param string|null $caption Document caption (may also be used when resending documents by file_id), 0-1024 characters after entities parsing
     * @param string|null $parse_mode Mode for parsing entities in the document caption. See formatting options for more details.
     * @param array<\MemoGram\Api\Types\MessageEntity>|null $caption_entities A JSON-serialized list of special entities that appear in the caption, which can be specified instead of parse_mode
     * @param bool|null $disable_content_type_detection Disables automatic server-side content type detection for files uploaded using multipart/form-data
     * @param bool|null $disable_notification Sends the message silently. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param bool|null $allow_paid_broadcast Pass True to allow up to 1000 messages per second, ignoring broadcasting limits for a fee of 0.1 Telegram Stars per message. The relevant Stars will be withdrawn from the bot's balance
     * @param string|null $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param SuggestedPostParameters|null $suggested_post_parameters A JSON-serialized object containing the parameters of the suggested post to send; for direct messages chats only. If the message is sent as a reply to another suggested post, then that suggested post is automatically declined.
     * @param ReplyParameters|null $reply_parameters Description of the message to reply to
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
     * @return Message|null
     */
    public function sendDocument(int|string $chat_id, mixed $document, ?string $business_connection_id = null, ?int $message_thread_id = null, ?int $direct_messages_topic_id = null, mixed $thumbnail = null, ?string $caption = null, ?string $parse_mode = null, ?array $caption_entities = null, ?bool $disable_content_type_detection = null, ?bool $disable_notification = null, ?bool $protect_content = null, ?bool $allow_paid_broadcast = null, ?string $message_effect_id = null, ?SuggestedPostParameters $suggested_post_parameters = null, ?ReplyParameters $reply_parameters = null, InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null, ...$args): Message|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('sendDocument', $vars), [Message::class]);
    }

    /**
     * Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param mixed|string $video Video to send. Pass a file_id as String to send a video that exists on the Telegram servers (recommended), pass an HTTP URL as a String for Telegram to get a video from the Internet, or upload a new video using multipart/form-data. More information on Sending Files »
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param int|null $direct_messages_topic_id Identifier of the direct messages topic to which the message will be sent; required if the message is sent to a direct messages chat
     * @param int|null $duration Duration of sent video in seconds
     * @param int|null $width Video width
     * @param int|null $height Video height
     * @param mixed|string|null $thumbnail Thumbnail of the file sent; can be ignored if thumbnail generation for the file is supported server-side. The thumbnail should be in JPEG format and less than 200 kB in size. A thumbnail's width and height should not exceed 320. Ignored if the file is not uploaded using multipart/form-data. Thumbnails can't be reused and can be only uploaded as a new file, so you can pass “attach://<file_attach_name>” if the thumbnail was uploaded using multipart/form-data under <file_attach_name>. More information on Sending Files »
     * @param mixed|string|null $cover Cover for the video in the message. Pass a file_id to send a file that exists on the Telegram servers (recommended), pass an HTTP URL for Telegram to get a file from the Internet, or pass “attach://<file_attach_name>” to upload a new one using multipart/form-data under <file_attach_name> name. More information on Sending Files »
     * @param int|null $start_timestamp Start timestamp for the video in the message
     * @param string|null $caption Video caption (may also be used when resending videos by file_id), 0-1024 characters after entities parsing
     * @param string|null $parse_mode Mode for parsing entities in the video caption. See formatting options for more details.
     * @param array<\MemoGram\Api\Types\MessageEntity>|null $caption_entities A JSON-serialized list of special entities that appear in the caption, which can be specified instead of parse_mode
     * @param bool|null $show_caption_above_media Pass True, if the caption must be shown above the message media
     * @param bool|null $has_spoiler Pass True if the video needs to be covered with a spoiler animation
     * @param bool|null $supports_streaming Pass True if the uploaded video is suitable for streaming
     * @param bool|null $disable_notification Sends the message silently. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param bool|null $allow_paid_broadcast Pass True to allow up to 1000 messages per second, ignoring broadcasting limits for a fee of 0.1 Telegram Stars per message. The relevant Stars will be withdrawn from the bot's balance
     * @param string|null $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param SuggestedPostParameters|null $suggested_post_parameters A JSON-serialized object containing the parameters of the suggested post to send; for direct messages chats only. If the message is sent as a reply to another suggested post, then that suggested post is automatically declined.
     * @param ReplyParameters|null $reply_parameters Description of the message to reply to
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
     * @return Message|null
     */
    public function sendVideo(int|string $chat_id, mixed $video, ?string $business_connection_id = null, ?int $message_thread_id = null, ?int $direct_messages_topic_id = null, ?int $duration = null, ?int $width = null, ?int $height = null, mixed $thumbnail = null, mixed $cover = null, ?int $start_timestamp = null, ?string $caption = null, ?string $parse_mode = null, ?array $caption_entities = null, ?bool $show_caption_above_media = null, ?bool $has_spoiler = null, ?bool $supports_streaming = null, ?bool $disable_notification = null, ?bool $protect_content = null, ?bool $allow_paid_broadcast = null, ?string $message_effect_id = null, ?SuggestedPostParameters $suggested_post_parameters = null, ?ReplyParameters $reply_parameters = null, InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null, ...$args): Message|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('sendVideo', $vars), [Message::class]);
    }

    /**
     * Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param mixed|string $animation Animation to send. Pass a file_id as String to send an animation that exists on the Telegram servers (recommended), pass an HTTP URL as a String for Telegram to get an animation from the Internet, or upload a new animation using multipart/form-data. More information on Sending Files »
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param int|null $direct_messages_topic_id Identifier of the direct messages topic to which the message will be sent; required if the message is sent to a direct messages chat
     * @param int|null $duration Duration of sent animation in seconds
     * @param int|null $width Animation width
     * @param int|null $height Animation height
     * @param mixed|string|null $thumbnail Thumbnail of the file sent; can be ignored if thumbnail generation for the file is supported server-side. The thumbnail should be in JPEG format and less than 200 kB in size. A thumbnail's width and height should not exceed 320. Ignored if the file is not uploaded using multipart/form-data. Thumbnails can't be reused and can be only uploaded as a new file, so you can pass “attach://<file_attach_name>” if the thumbnail was uploaded using multipart/form-data under <file_attach_name>. More information on Sending Files »
     * @param string|null $caption Animation caption (may also be used when resending animation by file_id), 0-1024 characters after entities parsing
     * @param string|null $parse_mode Mode for parsing entities in the animation caption. See formatting options for more details.
     * @param array<\MemoGram\Api\Types\MessageEntity>|null $caption_entities A JSON-serialized list of special entities that appear in the caption, which can be specified instead of parse_mode
     * @param bool|null $show_caption_above_media Pass True, if the caption must be shown above the message media
     * @param bool|null $has_spoiler Pass True if the animation needs to be covered with a spoiler animation
     * @param bool|null $disable_notification Sends the message silently. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param bool|null $allow_paid_broadcast Pass True to allow up to 1000 messages per second, ignoring broadcasting limits for a fee of 0.1 Telegram Stars per message. The relevant Stars will be withdrawn from the bot's balance
     * @param string|null $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param SuggestedPostParameters|null $suggested_post_parameters A JSON-serialized object containing the parameters of the suggested post to send; for direct messages chats only. If the message is sent as a reply to another suggested post, then that suggested post is automatically declined.
     * @param ReplyParameters|null $reply_parameters Description of the message to reply to
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
     * @return Message|null
     */
    public function sendAnimation(int|string $chat_id, mixed $animation, ?string $business_connection_id = null, ?int $message_thread_id = null, ?int $direct_messages_topic_id = null, ?int $duration = null, ?int $width = null, ?int $height = null, mixed $thumbnail = null, ?string $caption = null, ?string $parse_mode = null, ?array $caption_entities = null, ?bool $show_caption_above_media = null, ?bool $has_spoiler = null, ?bool $disable_notification = null, ?bool $protect_content = null, ?bool $allow_paid_broadcast = null, ?string $message_effect_id = null, ?SuggestedPostParameters $suggested_post_parameters = null, ?ReplyParameters $reply_parameters = null, InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null, ...$args): Message|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('sendAnimation', $vars), [Message::class]);
    }

    /**
     * Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param mixed|string $voice Audio file to send. Pass a file_id as String to send a file that exists on the Telegram servers (recommended), pass an HTTP URL as a String for Telegram to get a file from the Internet, or upload a new one using multipart/form-data. More information on Sending Files »
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param int|null $direct_messages_topic_id Identifier of the direct messages topic to which the message will be sent; required if the message is sent to a direct messages chat
     * @param string|null $caption Voice message caption, 0-1024 characters after entities parsing
     * @param string|null $parse_mode Mode for parsing entities in the voice message caption. See formatting options for more details.
     * @param array<\MemoGram\Api\Types\MessageEntity>|null $caption_entities A JSON-serialized list of special entities that appear in the caption, which can be specified instead of parse_mode
     * @param int|null $duration Duration of the voice message in seconds
     * @param bool|null $disable_notification Sends the message silently. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param bool|null $allow_paid_broadcast Pass True to allow up to 1000 messages per second, ignoring broadcasting limits for a fee of 0.1 Telegram Stars per message. The relevant Stars will be withdrawn from the bot's balance
     * @param string|null $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param SuggestedPostParameters|null $suggested_post_parameters A JSON-serialized object containing the parameters of the suggested post to send; for direct messages chats only. If the message is sent as a reply to another suggested post, then that suggested post is automatically declined.
     * @param ReplyParameters|null $reply_parameters Description of the message to reply to
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
     * @return Message|null
     */
    public function sendVoice(int|string $chat_id, mixed $voice, ?string $business_connection_id = null, ?int $message_thread_id = null, ?int $direct_messages_topic_id = null, ?string $caption = null, ?string $parse_mode = null, ?array $caption_entities = null, ?int $duration = null, ?bool $disable_notification = null, ?bool $protect_content = null, ?bool $allow_paid_broadcast = null, ?string $message_effect_id = null, ?SuggestedPostParameters $suggested_post_parameters = null, ?ReplyParameters $reply_parameters = null, InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null, ...$args): Message|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('sendVoice', $vars), [Message::class]);
    }

    /**
     * Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param mixed|string $video_note Video note to send. Pass a file_id as String to send a video note that exists on the Telegram servers (recommended) or upload a new video using multipart/form-data. More information on Sending Files ». Sending video notes by a URL is currently unsupported
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param int|null $direct_messages_topic_id Identifier of the direct messages topic to which the message will be sent; required if the message is sent to a direct messages chat
     * @param int|null $duration Duration of sent video in seconds
     * @param int|null $length Video width and height, i.e. diameter of the video message
     * @param mixed|string|null $thumbnail Thumbnail of the file sent; can be ignored if thumbnail generation for the file is supported server-side. The thumbnail should be in JPEG format and less than 200 kB in size. A thumbnail's width and height should not exceed 320. Ignored if the file is not uploaded using multipart/form-data. Thumbnails can't be reused and can be only uploaded as a new file, so you can pass “attach://<file_attach_name>” if the thumbnail was uploaded using multipart/form-data under <file_attach_name>. More information on Sending Files »
     * @param bool|null $disable_notification Sends the message silently. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param bool|null $allow_paid_broadcast Pass True to allow up to 1000 messages per second, ignoring broadcasting limits for a fee of 0.1 Telegram Stars per message. The relevant Stars will be withdrawn from the bot's balance
     * @param string|null $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param SuggestedPostParameters|null $suggested_post_parameters A JSON-serialized object containing the parameters of the suggested post to send; for direct messages chats only. If the message is sent as a reply to another suggested post, then that suggested post is automatically declined.
     * @param ReplyParameters|null $reply_parameters Description of the message to reply to
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
     * @return Message|null
     */
    public function sendVideoNote(int|string $chat_id, mixed $video_note, ?string $business_connection_id = null, ?int $message_thread_id = null, ?int $direct_messages_topic_id = null, ?int $duration = null, ?int $length = null, mixed $thumbnail = null, ?bool $disable_notification = null, ?bool $protect_content = null, ?bool $allow_paid_broadcast = null, ?string $message_effect_id = null, ?SuggestedPostParameters $suggested_post_parameters = null, ?ReplyParameters $reply_parameters = null, InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null, ...$args): Message|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('sendVideoNote', $vars), [Message::class]);
    }

    /**
     * Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername). If the chat is a channel, all Telegram Star proceeds from this media will be credited to the chat's balance. Otherwise, they will be credited to the bot's balance.
     * @param int $star_count The number of Telegram Stars that must be paid to buy access to the media; 1-10000
     * @param array<\MemoGram\Api\Types\InputPaidMedia> $media A JSON-serialized array describing the media to be sent; up to 10 items
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param int|null $direct_messages_topic_id Identifier of the direct messages topic to which the message will be sent; required if the message is sent to a direct messages chat
     * @param string|null $payload Bot-defined paid media payload, 0-128 bytes. This will not be displayed to the user, use it for your internal processes.
     * @param string|null $caption Media caption, 0-1024 characters after entities parsing
     * @param string|null $parse_mode Mode for parsing entities in the media caption. See formatting options for more details.
     * @param array<\MemoGram\Api\Types\MessageEntity>|null $caption_entities A JSON-serialized list of special entities that appear in the caption, which can be specified instead of parse_mode
     * @param bool|null $show_caption_above_media Pass True, if the caption must be shown above the message media
     * @param bool|null $disable_notification Sends the message silently. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param bool|null $allow_paid_broadcast Pass True to allow up to 1000 messages per second, ignoring broadcasting limits for a fee of 0.1 Telegram Stars per message. The relevant Stars will be withdrawn from the bot's balance
     * @param SuggestedPostParameters|null $suggested_post_parameters A JSON-serialized object containing the parameters of the suggested post to send; for direct messages chats only. If the message is sent as a reply to another suggested post, then that suggested post is automatically declined.
     * @param ReplyParameters|null $reply_parameters Description of the message to reply to
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
     * @return Message|null
     */
    public function sendPaidMedia(int|string $chat_id, int $star_count, array $media, ?string $business_connection_id = null, ?int $message_thread_id = null, ?int $direct_messages_topic_id = null, ?string $payload = null, ?string $caption = null, ?string $parse_mode = null, ?array $caption_entities = null, ?bool $show_caption_above_media = null, ?bool $disable_notification = null, ?bool $protect_content = null, ?bool $allow_paid_broadcast = null, ?SuggestedPostParameters $suggested_post_parameters = null, ?ReplyParameters $reply_parameters = null, InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null, ...$args): Message|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('sendPaidMedia', $vars), [Message::class]);
    }

    /**
     * Description of the message to reply to
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param array<InputMediaAudio|InputMediaDocument|InputMediaPhoto|InputMediaVideo|array> $media A JSON-serialized array describing messages to be sent, must include 2-10 items
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param int|null $direct_messages_topic_id Identifier of the direct messages topic to which the messages will be sent; required if the messages are sent to a direct messages chat
     * @param bool|null $disable_notification Sends messages silently. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent messages from forwarding and saving
     * @param bool|null $allow_paid_broadcast Pass True to allow up to 1000 messages per second, ignoring broadcasting limits for a fee of 0.1 Telegram Stars per message. The relevant Stars will be withdrawn from the bot's balance
     * @param string|null $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param ReplyParameters|null $reply_parameters Description of the message to reply to
     * @return mixed
     */
    public function sendMediaGroup(int|string $chat_id, array $media, ?string $business_connection_id = null, ?int $message_thread_id = null, ?int $direct_messages_topic_id = null, ?bool $disable_notification = null, ?bool $protect_content = null, ?bool $allow_paid_broadcast = null, ?string $message_effect_id = null, ?ReplyParameters $reply_parameters = null, ...$args): mixed
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('sendMediaGroup', $vars), ['mixed']);
    }

    /**
     * Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param float $latitude Latitude of the location
     * @param float $longitude Longitude of the location
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param int|null $direct_messages_topic_id Identifier of the direct messages topic to which the message will be sent; required if the message is sent to a direct messages chat
     * @param float|null $horizontal_accuracy The radius of uncertainty for the location, measured in meters; 0-1500
     * @param int|null $live_period Period in seconds during which the location will be updated (see Live Locations, should be between 60 and 86400, or 0x7FFFFFFF for live locations that can be edited indefinitely.
     * @param int|null $heading For live locations, a direction in which the user is moving, in degrees. Must be between 1 and 360 if specified.
     * @param int|null $proximity_alert_radius For live locations, a maximum distance for proximity alerts about approaching another chat member, in meters. Must be between 1 and 100000 if specified.
     * @param bool|null $disable_notification Sends the message silently. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param bool|null $allow_paid_broadcast Pass True to allow up to 1000 messages per second, ignoring broadcasting limits for a fee of 0.1 Telegram Stars per message. The relevant Stars will be withdrawn from the bot's balance
     * @param string|null $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param SuggestedPostParameters|null $suggested_post_parameters A JSON-serialized object containing the parameters of the suggested post to send; for direct messages chats only. If the message is sent as a reply to another suggested post, then that suggested post is automatically declined.
     * @param ReplyParameters|null $reply_parameters Description of the message to reply to
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
     * @return Message|null
     */
    public function sendLocation(int|string $chat_id, float $latitude, float $longitude, ?string $business_connection_id = null, ?int $message_thread_id = null, ?int $direct_messages_topic_id = null, ?float $horizontal_accuracy = null, ?int $live_period = null, ?int $heading = null, ?int $proximity_alert_radius = null, ?bool $disable_notification = null, ?bool $protect_content = null, ?bool $allow_paid_broadcast = null, ?string $message_effect_id = null, ?SuggestedPostParameters $suggested_post_parameters = null, ?ReplyParameters $reply_parameters = null, InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null, ...$args): Message|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('sendLocation', $vars), [Message::class]);
    }

    /**
     * Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param float $latitude Latitude of the venue
     * @param float $longitude Longitude of the venue
     * @param string $title Name of the venue
     * @param string $address Address of the venue
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param int|null $direct_messages_topic_id Identifier of the direct messages topic to which the message will be sent; required if the message is sent to a direct messages chat
     * @param string|null $foursquare_id Foursquare identifier of the venue
     * @param string|null $foursquare_type Foursquare type of the venue, if known. (For example, “arts_entertainment/default”, “arts_entertainment/aquarium” or “food/icecream”.)
     * @param string|null $google_place_id Google Places identifier of the venue
     * @param string|null $google_place_type Google Places type of the venue. (See supported types.)
     * @param bool|null $disable_notification Sends the message silently. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param bool|null $allow_paid_broadcast Pass True to allow up to 1000 messages per second, ignoring broadcasting limits for a fee of 0.1 Telegram Stars per message. The relevant Stars will be withdrawn from the bot's balance
     * @param string|null $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param SuggestedPostParameters|null $suggested_post_parameters A JSON-serialized object containing the parameters of the suggested post to send; for direct messages chats only. If the message is sent as a reply to another suggested post, then that suggested post is automatically declined.
     * @param ReplyParameters|null $reply_parameters Description of the message to reply to
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
     * @return Message|null
     */
    public function sendVenue(int|string $chat_id, float $latitude, float $longitude, string $title, string $address, ?string $business_connection_id = null, ?int $message_thread_id = null, ?int $direct_messages_topic_id = null, ?string $foursquare_id = null, ?string $foursquare_type = null, ?string $google_place_id = null, ?string $google_place_type = null, ?bool $disable_notification = null, ?bool $protect_content = null, ?bool $allow_paid_broadcast = null, ?string $message_effect_id = null, ?SuggestedPostParameters $suggested_post_parameters = null, ?ReplyParameters $reply_parameters = null, InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null, ...$args): Message|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('sendVenue', $vars), [Message::class]);
    }

    /**
     * Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param string $phone_number Contact's phone number
     * @param string $first_name Contact's first name
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param int|null $direct_messages_topic_id Identifier of the direct messages topic to which the message will be sent; required if the message is sent to a direct messages chat
     * @param string|null $last_name Contact's last name
     * @param string|null $vcard Additional data about the contact in the form of a vCard, 0-2048 bytes
     * @param bool|null $disable_notification Sends the message silently. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param bool|null $allow_paid_broadcast Pass True to allow up to 1000 messages per second, ignoring broadcasting limits for a fee of 0.1 Telegram Stars per message. The relevant Stars will be withdrawn from the bot's balance
     * @param string|null $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param SuggestedPostParameters|null $suggested_post_parameters A JSON-serialized object containing the parameters of the suggested post to send; for direct messages chats only. If the message is sent as a reply to another suggested post, then that suggested post is automatically declined.
     * @param ReplyParameters|null $reply_parameters Description of the message to reply to
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
     * @return Message|null
     */
    public function sendContact(int|string $chat_id, string $phone_number, string $first_name, ?string $business_connection_id = null, ?int $message_thread_id = null, ?int $direct_messages_topic_id = null, ?string $last_name = null, ?string $vcard = null, ?bool $disable_notification = null, ?bool $protect_content = null, ?bool $allow_paid_broadcast = null, ?string $message_effect_id = null, ?SuggestedPostParameters $suggested_post_parameters = null, ?ReplyParameters $reply_parameters = null, InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null, ...$args): Message|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('sendContact', $vars), [Message::class]);
    }

    /**
     * Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername). Polls can't be sent to channel direct messages chats.
     * @param string $question Poll question, 1-300 characters
     * @param array<\MemoGram\Api\Types\InputPollOption> $options A JSON-serialized list of 2-12 answer options
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param string|null $question_parse_mode Mode for parsing entities in the question. See formatting options for more details. Currently, only custom emoji entities are allowed
     * @param array<\MemoGram\Api\Types\MessageEntity>|null $question_entities A JSON-serialized list of special entities that appear in the poll question. It can be specified instead of question_parse_mode
     * @param bool|null $is_anonymous True, if the poll needs to be anonymous, defaults to True
     * @param string|null $type Poll type, “quiz” or “regular”, defaults to “regular”
     * @param bool|null $allows_multiple_answers True, if the poll allows multiple answers, ignored for polls in quiz mode, defaults to False
     * @param int|null $correct_option_id 0-based identifier of the correct answer option, required for polls in quiz mode
     * @param string|null $explanation Text that is shown when a user chooses an incorrect answer or taps on the lamp icon in a quiz-style poll, 0-200 characters with at most 2 line feeds after entities parsing
     * @param string|null $explanation_parse_mode Mode for parsing entities in the explanation. See formatting options for more details.
     * @param array<\MemoGram\Api\Types\MessageEntity>|null $explanation_entities A JSON-serialized list of special entities that appear in the poll explanation. It can be specified instead of explanation_parse_mode
     * @param int|null $open_period Amount of time in seconds the poll will be active after creation, 5-600. Can't be used together with close_date.
     * @param int|null $close_date Point in time (Unix timestamp) when the poll will be automatically closed. Must be at least 5 and no more than 600 seconds in the future. Can't be used together with open_period.
     * @param bool|null $is_closed Pass True if the poll needs to be immediately closed. This can be useful for poll preview.
     * @param bool|null $disable_notification Sends the message silently. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param bool|null $allow_paid_broadcast Pass True to allow up to 1000 messages per second, ignoring broadcasting limits for a fee of 0.1 Telegram Stars per message. The relevant Stars will be withdrawn from the bot's balance
     * @param string|null $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param ReplyParameters|null $reply_parameters Description of the message to reply to
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
     * @return Message|null
     */
    public function sendPoll(int|string $chat_id, string $question, array $options, ?string $business_connection_id = null, ?int $message_thread_id = null, ?string $question_parse_mode = null, ?array $question_entities = null, ?bool $is_anonymous = null, ?string $type = null, ?bool $allows_multiple_answers = null, ?int $correct_option_id = null, ?string $explanation = null, ?string $explanation_parse_mode = null, ?array $explanation_entities = null, ?int $open_period = null, ?int $close_date = null, ?bool $is_closed = null, ?bool $disable_notification = null, ?bool $protect_content = null, ?bool $allow_paid_broadcast = null, ?string $message_effect_id = null, ?ReplyParameters $reply_parameters = null, InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null, ...$args): Message|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('sendPoll', $vars), [Message::class]);
    }

    /**
     * A JSON-serialized object for an inline keyboard
     * @param string $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param int $chat_id Unique identifier for the target chat
     * @param InputChecklist $checklist A JSON-serialized object for the checklist to send
     * @param bool|null $disable_notification Sends the message silently. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param string|null $message_effect_id Unique identifier of the message effect to be added to the message
     * @param ReplyParameters|null $reply_parameters A JSON-serialized object for description of the message to reply to
     * @param InlineKeyboardMarkup|null $reply_markup A JSON-serialized object for an inline keyboard
     * @return Message|null
     */
    public function sendChecklist(string $business_connection_id, int $chat_id, InputChecklist $checklist, ?bool $disable_notification = null, ?bool $protect_content = null, ?string $message_effect_id = null, ?ReplyParameters $reply_parameters = null, ?InlineKeyboardMarkup $reply_markup = null, ...$args): Message|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('sendChecklist', $vars), [Message::class]);
    }

    /**
     * Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param int|null $direct_messages_topic_id Identifier of the direct messages topic to which the message will be sent; required if the message is sent to a direct messages chat
     * @param string|null $emoji Emoji on which the dice throw animation is based. Currently, must be one of “”, “”, “”, “”, “”, or “”. Dice can have values 1-6 for “”, “” and “”, values 1-5 for “” and “”, and values 1-64 for “”. Defaults to “”
     * @param bool|null $disable_notification Sends the message silently. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding
     * @param bool|null $allow_paid_broadcast Pass True to allow up to 1000 messages per second, ignoring broadcasting limits for a fee of 0.1 Telegram Stars per message. The relevant Stars will be withdrawn from the bot's balance
     * @param string|null $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param SuggestedPostParameters|null $suggested_post_parameters A JSON-serialized object containing the parameters of the suggested post to send; for direct messages chats only. If the message is sent as a reply to another suggested post, then that suggested post is automatically declined.
     * @param ReplyParameters|null $reply_parameters Description of the message to reply to
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
     * @return Message|null
     */
    public function sendDice(int|string $chat_id, ?string $business_connection_id = null, ?int $message_thread_id = null, ?int $direct_messages_topic_id = null, ?string $emoji = null, ?bool $disable_notification = null, ?bool $protect_content = null, ?bool $allow_paid_broadcast = null, ?string $message_effect_id = null, ?SuggestedPostParameters $suggested_post_parameters = null, ?ReplyParameters $reply_parameters = null, InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null, ...$args): Message|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('sendDice', $vars), [Message::class]);
    }

    /**
     * Type of action to broadcast. Choose one, depending on what the user is about to receive: typing for text messages, upload_photo for photos, record_video or upload_video for videos, record_voice or upload_voice for voice notes, upload_document for general files, choose_sticker for stickers, find_location for location data, record_video_note or upload_video_note for video notes.
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername). Channel chats and channel direct messages chats aren't supported.
     * @param string $action Type of action to broadcast. Choose one, depending on what the user is about to receive: typing for text messages, upload_photo for photos, record_video or upload_video for videos, record_voice or upload_voice for voice notes, upload_document for general files, choose_sticker for stickers, find_location for location data, record_video_note or upload_video_note for video notes.
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the action will be sent
     * @param int|null $message_thread_id Unique identifier for the target message thread; for supergroups only
     * @return true|null
     */
    public function sendChatAction(int|string $chat_id, string $action, ?string $business_connection_id = null, ?int $message_thread_id = null, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('sendChatAction', $vars), ['true']);
    }

    /**
     * Pass True to set the reaction with a big animation
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param int $message_id Identifier of the target message. If the message belongs to a media group, the reaction is set to the first non-deleted message in the group instead.
     * @param array<\MemoGram\Api\Types\ReactionType>|null $reaction A JSON-serialized list of reaction types to set on the message. Currently, as non-premium users, bots can set up to one reaction per message. A custom emoji reaction can be used if it is either already present on the message or explicitly allowed by chat administrators. Paid reactions can't be used by bots.
     * @param bool|null $is_big Pass True to set the reaction with a big animation
     * @return true|null
     */
    public function setMessageReaction(int|string $chat_id, int $message_id, ?array $reaction = null, ?bool $is_big = null, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('setMessageReaction', $vars), ['true']);
    }

    /**
     * Limits the number of photos to be retrieved. Values between 1-100 are accepted. Defaults to 100.
     * @param int $user_id Unique identifier of the target user
     * @param int|null $offset Sequential number of the first photo to be returned. By default, all photos are returned.
     * @param int|null $limit Limits the number of photos to be retrieved. Values between 1-100 are accepted. Defaults to 100.
     * @return UserProfilePhotos|null
     */
    public function getUserProfilePhotos(int $user_id, ?int $offset = null, ?int $limit = null, ...$args): UserProfilePhotos|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('getUserProfilePhotos', $vars), [UserProfilePhotos::class]);
    }

    /**
     * Expiration date of the emoji status, if any
     * @param int $user_id Unique identifier of the target user
     * @param string|null $emoji_status_custom_emoji_id Custom emoji identifier of the emoji status to set. Pass an empty string to remove the status.
     * @param int|null $emoji_status_expiration_date Expiration date of the emoji status, if any
     * @return true|null
     */
    public function setUserEmojiStatus(int $user_id, ?string $emoji_status_custom_emoji_id = null, ?int $emoji_status_expiration_date = null, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('setUserEmojiStatus', $vars), ['true']);
    }

    /**
     * File identifier to get information about
     * @param string $file_id File identifier to get information about
     * @return mixed
     */
    public function getFile(string $file_id, ...$args): mixed
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('getFile', $vars), ['mixed']);
    }

    /**
     * Pass True to delete all messages from the chat for the user that is being removed. If False, the user will be able to see messages in the group that were sent before the user was removed. Always True for supergroups and channels.
     * @param int|string $chat_id Unique identifier for the target group or username of the target supergroup or channel (in the format @channelusername)
     * @param int $user_id Unique identifier of the target user
     * @param int|null $until_date Date when the user will be unbanned; Unix time. If user is banned for more than 366 days or less than 30 seconds from the current time they are considered to be banned forever. Applied for supergroups and channels only.
     * @param bool|null $revoke_messages Pass True to delete all messages from the chat for the user that is being removed. If False, the user will be able to see messages in the group that were sent before the user was removed. Always True for supergroups and channels.
     * @return true|null
     */
    public function banChatMember(int|string $chat_id, int $user_id, ?int $until_date = null, ?bool $revoke_messages = null, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('banChatMember', $vars), ['true']);
    }

    /**
     * Do nothing if the user is not banned
     * @param int|string $chat_id Unique identifier for the target group or username of the target supergroup or channel (in the format @channelusername)
     * @param int $user_id Unique identifier of the target user
     * @param bool|null $only_if_banned Do nothing if the user is not banned
     * @return true|null
     */
    public function unbanChatMember(int|string $chat_id, int $user_id, ?bool $only_if_banned = null, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('unbanChatMember', $vars), ['true']);
    }

    /**
     * Date when restrictions will be lifted for the user; Unix time. If user is restricted for more than 366 days or less than 30 seconds from the current time, they are considered to be restricted forever
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername)
     * @param int $user_id Unique identifier of the target user
     * @param ChatPermissions $permissions A JSON-serialized object for new user permissions
     * @param bool|null $use_independent_chat_permissions Pass True if chat permissions are set independently. Otherwise, the can_send_other_messages and can_add_web_page_previews permissions will imply the can_send_messages, can_send_audios, can_send_documents, can_send_photos, can_send_videos, can_send_video_notes, and can_send_voice_notes permissions; the can_send_polls permission will imply the can_send_messages permission.
     * @param int|null $until_date Date when restrictions will be lifted for the user; Unix time. If user is restricted for more than 366 days or less than 30 seconds from the current time, they are considered to be restricted forever
     * @return true|null
     */
    public function restrictChatMember(int|string $chat_id, int $user_id, ChatPermissions $permissions, ?bool $use_independent_chat_permissions = null, ?int $until_date = null, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('restrictChatMember', $vars), ['true']);
    }

    /**
     * Pass True if the administrator can manage direct messages within the channel and decline suggested posts; for channels only
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param int $user_id Unique identifier of the target user
     * @param bool|null $is_anonymous Pass True if the administrator's presence in the chat is hidden
     * @param bool|null $can_manage_chat Pass True if the administrator can access the chat event log, get boost list, see hidden supergroup and channel members, report spam messages, ignore slow mode, and send messages to the chat without paying Telegram Stars. Implied by any other administrator privilege.
     * @param bool|null $can_delete_messages Pass True if the administrator can delete messages of other users
     * @param bool|null $can_manage_video_chats Pass True if the administrator can manage video chats
     * @param bool|null $can_restrict_members Pass True if the administrator can restrict, ban or unban chat members, or access supergroup statistics
     * @param bool|null $can_promote_members Pass True if the administrator can add new administrators with a subset of their own privileges or demote administrators that they have promoted, directly or indirectly (promoted by administrators that were appointed by him)
     * @param bool|null $can_change_info Pass True if the administrator can change chat title, photo and other settings
     * @param bool|null $can_invite_users Pass True if the administrator can invite new users to the chat
     * @param bool|null $can_post_stories Pass True if the administrator can post stories to the chat
     * @param bool|null $can_edit_stories Pass True if the administrator can edit stories posted by other users, post stories to the chat page, pin chat stories, and access the chat's story archive
     * @param bool|null $can_delete_stories Pass True if the administrator can delete stories posted by other users
     * @param bool|null $can_post_messages Pass True if the administrator can post messages in the channel, approve suggested posts, or access channel statistics; for channels only
     * @param bool|null $can_edit_messages Pass True if the administrator can edit messages of other users and can pin messages; for channels only
     * @param bool|null $can_pin_messages Pass True if the administrator can pin messages; for supergroups only
     * @param bool|null $can_manage_topics Pass True if the user is allowed to create, rename, close, and reopen forum topics; for supergroups only
     * @param bool|null $can_manage_direct_messages Pass True if the administrator can manage direct messages within the channel and decline suggested posts; for channels only
     * @return true|null
     */
    public function promoteChatMember(int|string $chat_id, int $user_id, ?bool $is_anonymous = null, ?bool $can_manage_chat = null, ?bool $can_delete_messages = null, ?bool $can_manage_video_chats = null, ?bool $can_restrict_members = null, ?bool $can_promote_members = null, ?bool $can_change_info = null, ?bool $can_invite_users = null, ?bool $can_post_stories = null, ?bool $can_edit_stories = null, ?bool $can_delete_stories = null, ?bool $can_post_messages = null, ?bool $can_edit_messages = null, ?bool $can_pin_messages = null, ?bool $can_manage_topics = null, ?bool $can_manage_direct_messages = null, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('promoteChatMember', $vars), ['true']);
    }

    /**
     * New custom title for the administrator; 0-16 characters, emoji are not allowed
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername)
     * @param int $user_id Unique identifier of the target user
     * @param string $custom_title New custom title for the administrator; 0-16 characters, emoji are not allowed
     * @return true|null
     */
    public function setChatAdministratorCustomTitle(int|string $chat_id, int $user_id, string $custom_title, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('setChatAdministratorCustomTitle', $vars), ['true']);
    }

    /**
     * Unique identifier of the target sender chat
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param int $sender_chat_id Unique identifier of the target sender chat
     * @return true|null
     */
    public function banChatSenderChat(int|string $chat_id, int $sender_chat_id, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('banChatSenderChat', $vars), ['true']);
    }

    /**
     * Unique identifier of the target sender chat
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param int $sender_chat_id Unique identifier of the target sender chat
     * @return true|null
     */
    public function unbanChatSenderChat(int|string $chat_id, int $sender_chat_id, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('unbanChatSenderChat', $vars), ['true']);
    }

    /**
     * Pass True if chat permissions are set independently. Otherwise, the can_send_other_messages and can_add_web_page_previews permissions will imply the can_send_messages, can_send_audios, can_send_documents, can_send_photos, can_send_videos, can_send_video_notes, and can_send_voice_notes permissions; the can_send_polls permission will imply the can_send_messages permission.
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername)
     * @param ChatPermissions $permissions A JSON-serialized object for new default chat permissions
     * @param bool|null $use_independent_chat_permissions Pass True if chat permissions are set independently. Otherwise, the can_send_other_messages and can_add_web_page_previews permissions will imply the can_send_messages, can_send_audios, can_send_documents, can_send_photos, can_send_videos, can_send_video_notes, and can_send_voice_notes permissions; the can_send_polls permission will imply the can_send_messages permission.
     * @return true|null
     */
    public function setChatPermissions(int|string $chat_id, ChatPermissions $permissions, ?bool $use_independent_chat_permissions = null, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('setChatPermissions', $vars), ['true']);
    }

    /**
     * Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @return string|null
     */
    public function exportChatInviteLink(int|string $chat_id, ...$args): string|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('exportChatInviteLink', $vars), ['string']);
    }

    /**
     * True, if users joining the chat via the link need to be approved by chat administrators. If True, member_limit can't be specified
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param string|null $name Invite link name; 0-32 characters
     * @param int|null $expire_date Point in time (Unix timestamp) when the link will expire
     * @param int|null $member_limit The maximum number of users that can be members of the chat simultaneously after joining the chat via this invite link; 1-99999
     * @param bool|null $creates_join_request True, if users joining the chat via the link need to be approved by chat administrators. If True, member_limit can't be specified
     * @return ChatInviteLink|null
     */
    public function createChatInviteLink(int|string $chat_id, ?string $name = null, ?int $expire_date = null, ?int $member_limit = null, ?bool $creates_join_request = null, ...$args): ChatInviteLink|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('createChatInviteLink', $vars), [ChatInviteLink::class]);
    }

    /**
     * True, if users joining the chat via the link need to be approved by chat administrators. If True, member_limit can't be specified
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param string $invite_link The invite link to edit
     * @param string|null $name Invite link name; 0-32 characters
     * @param int|null $expire_date Point in time (Unix timestamp) when the link will expire
     * @param int|null $member_limit The maximum number of users that can be members of the chat simultaneously after joining the chat via this invite link; 1-99999
     * @param bool|null $creates_join_request True, if users joining the chat via the link need to be approved by chat administrators. If True, member_limit can't be specified
     * @return ChatInviteLink|null
     */
    public function editChatInviteLink(int|string $chat_id, string $invite_link, ?string $name = null, ?int $expire_date = null, ?int $member_limit = null, ?bool $creates_join_request = null, ...$args): ChatInviteLink|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('editChatInviteLink', $vars), [ChatInviteLink::class]);
    }

    /**
     * The amount of Telegram Stars a user must pay initially and after each subsequent subscription period to be a member of the chat; 1-10000
     * @param int|string $chat_id Unique identifier for the target channel chat or username of the target channel (in the format @channelusername)
     * @param int $subscription_period The number of seconds the subscription will be active for before the next payment. Currently, it must always be 2592000 (30 days).
     * @param int $subscription_price The amount of Telegram Stars a user must pay initially and after each subsequent subscription period to be a member of the chat; 1-10000
     * @param string|null $name Invite link name; 0-32 characters
     * @return ChatInviteLink|null
     */
    public function createChatSubscriptionInviteLink(int|string $chat_id, int $subscription_period, int $subscription_price, ?string $name = null, ...$args): ChatInviteLink|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('createChatSubscriptionInviteLink', $vars), [ChatInviteLink::class]);
    }

    /**
     * Invite link name; 0-32 characters
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param string $invite_link The invite link to edit
     * @param string|null $name Invite link name; 0-32 characters
     * @return ChatInviteLink|null
     */
    public function editChatSubscriptionInviteLink(int|string $chat_id, string $invite_link, ?string $name = null, ...$args): ChatInviteLink|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('editChatSubscriptionInviteLink', $vars), [ChatInviteLink::class]);
    }

    /**
     * The invite link to revoke
     * @param int|string $chat_id Unique identifier of the target chat or username of the target channel (in the format @channelusername)
     * @param string $invite_link The invite link to revoke
     * @return ChatInviteLink|null
     */
    public function revokeChatInviteLink(int|string $chat_id, string $invite_link, ...$args): ChatInviteLink|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('revokeChatInviteLink', $vars), [ChatInviteLink::class]);
    }

    /**
     * Unique identifier of the target user
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param int $user_id Unique identifier of the target user
     * @return true|null
     */
    public function approveChatJoinRequest(int|string $chat_id, int $user_id, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('approveChatJoinRequest', $vars), ['true']);
    }

    /**
     * Unique identifier of the target user
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param int $user_id Unique identifier of the target user
     * @return true|null
     */
    public function declineChatJoinRequest(int|string $chat_id, int $user_id, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('declineChatJoinRequest', $vars), ['true']);
    }

    /**
     * New chat photo, uploaded using multipart/form-data
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param mixed $photo New chat photo, uploaded using multipart/form-data
     * @return true|null
     */
    public function setChatPhoto(int|string $chat_id, mixed $photo, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('setChatPhoto', $vars), ['true']);
    }

    /**
     * Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @return true|null
     */
    public function deleteChatPhoto(int|string $chat_id, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('deleteChatPhoto', $vars), ['true']);
    }

    /**
     * New chat title, 1-128 characters
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param string $title New chat title, 1-128 characters
     * @return true|null
     */
    public function setChatTitle(int|string $chat_id, string $title, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('setChatTitle', $vars), ['true']);
    }

    /**
     * New chat description, 0-255 characters
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param string|null $description New chat description, 0-255 characters
     * @return true|null
     */
    public function setChatDescription(int|string $chat_id, ?string $description = null, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('setChatDescription', $vars), ['true']);
    }

    /**
     * Pass True if it is not necessary to send a notification to all chat members about the new pinned message. Notifications are always disabled in channels and private chats.
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param int $message_id Identifier of a message to pin
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be pinned
     * @param bool|null $disable_notification Pass True if it is not necessary to send a notification to all chat members about the new pinned message. Notifications are always disabled in channels and private chats.
     * @return true|null
     */
    public function pinChatMessage(int|string $chat_id, int $message_id, ?string $business_connection_id = null, ?bool $disable_notification = null, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('pinChatMessage', $vars), ['true']);
    }

    /**
     * Identifier of the message to unpin. Required if business_connection_id is specified. If not specified, the most recent pinned message (by sending date) will be unpinned.
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be unpinned
     * @param int|null $message_id Identifier of the message to unpin. Required if business_connection_id is specified. If not specified, the most recent pinned message (by sending date) will be unpinned.
     * @return true|null
     */
    public function unpinChatMessage(int|string $chat_id, ?string $business_connection_id = null, ?int $message_id = null, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('unpinChatMessage', $vars), ['true']);
    }

    /**
     * Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @return true|null
     */
    public function unpinAllChatMessages(int|string $chat_id, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('unpinAllChatMessages', $vars), ['true']);
    }

    /**
     * Unique identifier for the target chat or username of the target supergroup or channel (in the format @channelusername). Channel direct messages chats aren't supported; leave the corresponding channel instead.
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup or channel (in the format @channelusername). Channel direct messages chats aren't supported; leave the corresponding channel instead.
     * @return true|null
     */
    public function leaveChat(int|string $chat_id, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('leaveChat', $vars), ['true']);
    }

    /**
     * Unique identifier for the target chat or username of the target supergroup or channel (in the format @channelusername)
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup or channel (in the format @channelusername)
     * @return ChatFullInfo|null
     */
    public function getChat(int|string $chat_id, ...$args): ChatFullInfo|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('getChat', $vars), [ChatFullInfo::class]);
    }

    /**
     * Unique identifier for the target chat or username of the target supergroup or channel (in the format @channelusername)
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup or channel (in the format @channelusername)
     * @return array<ChatMember>|null
     */
    public function getChatAdministrators(int|string $chat_id, ...$args): array|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('getChatAdministrators', $vars), ['array', ChatMember::class]);
    }

    /**
     * Unique identifier for the target chat or username of the target supergroup or channel (in the format @channelusername)
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup or channel (in the format @channelusername)
     * @return int|null
     */
    public function getChatMemberCount(int|string $chat_id, ...$args): int|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('getChatMemberCount', $vars), ['int']);
    }

    /**
     * Unique identifier of the target user
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup or channel (in the format @channelusername)
     * @param int $user_id Unique identifier of the target user
     * @return ChatMember|null
     */
    public function getChatMember(int|string $chat_id, int $user_id, ...$args): ChatMember|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('getChatMember', $vars), [ChatMember::class]);
    }

    /**
     * Name of the sticker set to be set as the group sticker set
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername)
     * @param string $sticker_set_name Name of the sticker set to be set as the group sticker set
     * @return true|null
     */
    public function setChatStickerSet(int|string $chat_id, string $sticker_set_name, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('setChatStickerSet', $vars), ['true']);
    }

    /**
     * Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername)
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername)
     * @return true|null
     */
    public function deleteChatStickerSet(int|string $chat_id, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('deleteChatStickerSet', $vars), ['true']);
    }

    /**
     * Unique identifier of the custom emoji shown as the topic icon. Use getForumTopicIconStickers to get all allowed custom emoji identifiers.
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername)
     * @param string $name Topic name, 1-128 characters
     * @param int|null $icon_color Color of the topic icon in RGB format. Currently, must be one of 7322096 (0x6FB9F0), 16766590 (0xFFD67E), 13338331 (0xCB86DB), 9367192 (0x8EEE98), 16749490 (0xFF93B2), or 16478047 (0xFB6F5F)
     * @param string|null $icon_custom_emoji_id Unique identifier of the custom emoji shown as the topic icon. Use getForumTopicIconStickers to get all allowed custom emoji identifiers.
     * @return ForumTopic|null
     */
    public function getForumTopicIconStickers(int|string $chat_id, string $name, ?int $icon_color = null, ?string $icon_custom_emoji_id = null, ...$args): ForumTopic|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('getForumTopicIconStickers', $vars), [ForumTopic::class]);
    }

    /**
     * Unique identifier of the custom emoji shown as the topic icon. Use getForumTopicIconStickers to get all allowed custom emoji identifiers.
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername)
     * @param string $name Topic name, 1-128 characters
     * @param int|null $icon_color Color of the topic icon in RGB format. Currently, must be one of 7322096 (0x6FB9F0), 16766590 (0xFFD67E), 13338331 (0xCB86DB), 9367192 (0x8EEE98), 16749490 (0xFF93B2), or 16478047 (0xFB6F5F)
     * @param string|null $icon_custom_emoji_id Unique identifier of the custom emoji shown as the topic icon. Use getForumTopicIconStickers to get all allowed custom emoji identifiers.
     * @return ForumTopic|null
     */
    public function createForumTopic(int|string $chat_id, string $name, ?int $icon_color = null, ?string $icon_custom_emoji_id = null, ...$args): ForumTopic|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('createForumTopic', $vars), [ForumTopic::class]);
    }

    /**
     * New unique identifier of the custom emoji shown as the topic icon. Use getForumTopicIconStickers to get all allowed custom emoji identifiers. Pass an empty string to remove the icon. If not specified, the current icon will be kept
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername)
     * @param int $message_thread_id Unique identifier for the target message thread of the forum topic
     * @param string|null $name New topic name, 0-128 characters. If not specified or empty, the current name of the topic will be kept
     * @param string|null $icon_custom_emoji_id New unique identifier of the custom emoji shown as the topic icon. Use getForumTopicIconStickers to get all allowed custom emoji identifiers. Pass an empty string to remove the icon. If not specified, the current icon will be kept
     * @return true|null
     */
    public function editForumTopic(int|string $chat_id, int $message_thread_id, ?string $name = null, ?string $icon_custom_emoji_id = null, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('editForumTopic', $vars), ['true']);
    }

    /**
     * Unique identifier for the target message thread of the forum topic
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername)
     * @param int $message_thread_id Unique identifier for the target message thread of the forum topic
     * @return true|null
     */
    public function closeForumTopic(int|string $chat_id, int $message_thread_id, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('closeForumTopic', $vars), ['true']);
    }

    /**
     * Unique identifier for the target message thread of the forum topic
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername)
     * @param int $message_thread_id Unique identifier for the target message thread of the forum topic
     * @return true|null
     */
    public function reopenForumTopic(int|string $chat_id, int $message_thread_id, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('reopenForumTopic', $vars), ['true']);
    }

    /**
     * Unique identifier for the target message thread of the forum topic
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername)
     * @param int $message_thread_id Unique identifier for the target message thread of the forum topic
     * @return true|null
     */
    public function deleteForumTopic(int|string $chat_id, int $message_thread_id, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('deleteForumTopic', $vars), ['true']);
    }

    /**
     * Unique identifier for the target message thread of the forum topic
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername)
     * @param int $message_thread_id Unique identifier for the target message thread of the forum topic
     * @return true|null
     */
    public function unpinAllForumTopicMessages(int|string $chat_id, int $message_thread_id, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('unpinAllForumTopicMessages', $vars), ['true']);
    }

    /**
     * New topic name, 1-128 characters
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername)
     * @param string $name New topic name, 1-128 characters
     * @return true|null
     */
    public function editGeneralForumTopic(int|string $chat_id, string $name, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('editGeneralForumTopic', $vars), ['true']);
    }

    /**
     * Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername)
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername)
     * @return true|null
     */
    public function closeGeneralForumTopic(int|string $chat_id, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('closeGeneralForumTopic', $vars), ['true']);
    }

    /**
     * Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername)
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername)
     * @return true|null
     */
    public function reopenGeneralForumTopic(int|string $chat_id, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('reopenGeneralForumTopic', $vars), ['true']);
    }

    /**
     * Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername)
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername)
     * @return true|null
     */
    public function hideGeneralForumTopic(int|string $chat_id, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('hideGeneralForumTopic', $vars), ['true']);
    }

    /**
     * Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername)
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername)
     * @return true|null
     */
    public function unhideGeneralForumTopic(int|string $chat_id, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('unhideGeneralForumTopic', $vars), ['true']);
    }

    /**
     * Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername)
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername)
     * @return true|null
     */
    public function unpinAllGeneralForumTopicMessages(int|string $chat_id, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('unpinAllGeneralForumTopicMessages', $vars), ['true']);
    }

    /**
     * The maximum amount of time in seconds that the result of the callback query may be cached client-side. Telegram apps will support caching starting in version 3.14. Defaults to 0.
     * @param string $callback_query_id Unique identifier for the query to be answered
     * @param string|null $text Text of the notification. If not specified, nothing will be shown to the user, 0-200 characters
     * @param bool|null $show_alert If True, an alert will be shown by the client instead of a notification at the top of the chat screen. Defaults to false.
     * @param string|null $url URL that will be opened by the user's client. If you have created a Game and accepted the conditions via @BotFather, specify the URL that opens your game - note that this will only work if the query comes from a callback_game button.Otherwise, you may use links like t.me/your_bot?start=XXXX that open your bot with a parameter.
     * @param int|null $cache_time The maximum amount of time in seconds that the result of the callback query may be cached client-side. Telegram apps will support caching starting in version 3.14. Defaults to 0.
     * @return mixed
     */
    public function answerCallbackQuery(string $callback_query_id, ?string $text = null, ?bool $show_alert = null, ?string $url = null, ?int $cache_time = null, ...$args): mixed
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('answerCallbackQuery', $vars), ['mixed']);
    }

    /**
     * Unique identifier of the target user
     * @param int|string $chat_id Unique identifier for the chat or username of the channel (in the format @channelusername)
     * @param int $user_id Unique identifier of the target user
     * @return UserChatBoosts|null
     */
    public function getUserChatBoosts(int|string $chat_id, int $user_id, ...$args): UserChatBoosts|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('getUserChatBoosts', $vars), [UserChatBoosts::class]);
    }

    /**
     * Unique identifier of the business connection
     * @param string $business_connection_id Unique identifier of the business connection
     * @return BusinessConnection|null
     */
    public function getBusinessConnection(string $business_connection_id, ...$args): BusinessConnection|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('getBusinessConnection', $vars), [BusinessConnection::class]);
    }

    /**
     * A two-letter ISO 639-1 language code. If empty, commands will be applied to all users from the given scope, for whose language there are no dedicated commands
     * @param array<\MemoGram\Api\Types\BotCommand> $commands A JSON-serialized list of bot commands to be set as the list of the bot's commands. At most 100 commands can be specified.
     * @param BotCommandScope|null $scope A JSON-serialized object, describing scope of users for which the commands are relevant. Defaults to BotCommandScopeDefault.
     * @param string|null $language_code A two-letter ISO 639-1 language code. If empty, commands will be applied to all users from the given scope, for whose language there are no dedicated commands
     * @return true|null
     */
    public function setMyCommands(array $commands, ?BotCommandScope $scope = null, ?string $language_code = null, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('setMyCommands', $vars), ['true']);
    }

    /**
     * A two-letter ISO 639-1 language code. If empty, commands will be applied to all users from the given scope, for whose language there are no dedicated commands
     * @param BotCommandScope|null $scope A JSON-serialized object, describing scope of users for which the commands are relevant. Defaults to BotCommandScopeDefault.
     * @param string|null $language_code A two-letter ISO 639-1 language code. If empty, commands will be applied to all users from the given scope, for whose language there are no dedicated commands
     * @return true|null
     */
    public function deleteMyCommands(?BotCommandScope $scope = null, ?string $language_code = null, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('deleteMyCommands', $vars), ['true']);
    }

    /**
     * A two-letter ISO 639-1 language code or an empty string
     * @param BotCommandScope|null $scope A JSON-serialized object, describing scope of users. Defaults to BotCommandScopeDefault.
     * @param string|null $language_code A two-letter ISO 639-1 language code or an empty string
     * @return array<BotCommand>|null
     */
    public function getMyCommands(?BotCommandScope $scope = null, ?string $language_code = null, ...$args): array|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('getMyCommands', $vars), ['array', BotCommand::class]);
    }

    /**
     * A two-letter ISO 639-1 language code. If empty, the name will be shown to all users for whose language there is no dedicated name.
     * @param string|null $name New bot name; 0-64 characters. Pass an empty string to remove the dedicated name for the given language.
     * @param string|null $language_code A two-letter ISO 639-1 language code. If empty, the name will be shown to all users for whose language there is no dedicated name.
     * @return true|null
     */
    public function setMyName(?string $name = null, ?string $language_code = null, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('setMyName', $vars), ['true']);
    }

    /**
     * A two-letter ISO 639-1 language code or an empty string
     * @param string|null $language_code A two-letter ISO 639-1 language code or an empty string
     * @return BotName|null
     */
    public function getMyName(?string $language_code = null, ...$args): BotName|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('getMyName', $vars), [BotName::class]);
    }

    /**
     * A two-letter ISO 639-1 language code. If empty, the description will be applied to all users for whose language there is no dedicated description.
     * @param string|null $description New bot description; 0-512 characters. Pass an empty string to remove the dedicated description for the given language.
     * @param string|null $language_code A two-letter ISO 639-1 language code. If empty, the description will be applied to all users for whose language there is no dedicated description.
     * @return true|null
     */
    public function setMyDescription(?string $description = null, ?string $language_code = null, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('setMyDescription', $vars), ['true']);
    }

    /**
     * A two-letter ISO 639-1 language code or an empty string
     * @param string|null $language_code A two-letter ISO 639-1 language code or an empty string
     * @return BotDescription|null
     */
    public function getMyDescription(?string $language_code = null, ...$args): BotDescription|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('getMyDescription', $vars), [BotDescription::class]);
    }

    /**
     * A two-letter ISO 639-1 language code. If empty, the short description will be applied to all users for whose language there is no dedicated short description.
     * @param string|null $short_description New short description for the bot; 0-120 characters. Pass an empty string to remove the dedicated short description for the given language.
     * @param string|null $language_code A two-letter ISO 639-1 language code. If empty, the short description will be applied to all users for whose language there is no dedicated short description.
     * @return true|null
     */
    public function setMyShortDescription(?string $short_description = null, ?string $language_code = null, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('setMyShortDescription', $vars), ['true']);
    }

    /**
     * A two-letter ISO 639-1 language code or an empty string
     * @param string|null $language_code A two-letter ISO 639-1 language code or an empty string
     * @return BotShortDescription|null
     */
    public function getMyShortDescription(?string $language_code = null, ...$args): BotShortDescription|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('getMyShortDescription', $vars), [BotShortDescription::class]);
    }

    /**
     * A JSON-serialized object for the bot's new menu button. Defaults to MenuButtonDefault
     * @param int|null $chat_id Unique identifier for the target private chat. If not specified, default bot's menu button will be changed
     * @param MenuButton|null $menu_button A JSON-serialized object for the bot's new menu button. Defaults to MenuButtonDefault
     * @return true|null
     */
    public function setChatMenuButton(?int $chat_id = null, ?MenuButton $menu_button = null, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('setChatMenuButton', $vars), ['true']);
    }

    /**
     * Unique identifier for the target private chat. If not specified, default bot's menu button will be returned
     * @param int|null $chat_id Unique identifier for the target private chat. If not specified, default bot's menu button will be returned
     * @return MenuButton|null
     */
    public function getChatMenuButton(?int $chat_id = null, ...$args): MenuButton|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('getChatMenuButton', $vars), [MenuButton::class]);
    }

    /**
     * Pass True to change the default administrator rights of the bot in channels. Otherwise, the default administrator rights of the bot for groups and supergroups will be changed.
     * @param ChatAdministratorRights|null $rights A JSON-serialized object describing new default administrator rights. If not specified, the default administrator rights will be cleared.
     * @param bool|null $for_channels Pass True to change the default administrator rights of the bot in channels. Otherwise, the default administrator rights of the bot for groups and supergroups will be changed.
     * @return true|null
     */
    public function setMyDefaultAdministratorRights(?ChatAdministratorRights $rights = null, ?bool $for_channels = null, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('setMyDefaultAdministratorRights', $vars), ['true']);
    }

    /**
     * Pass True to get default administrator rights of the bot in channels. Otherwise, default administrator rights of the bot for groups and supergroups will be returned.
     * @param bool|null $for_channels Pass True to get default administrator rights of the bot in channels. Otherwise, default administrator rights of the bot for groups and supergroups will be returned.
     * @return ChatAdministratorRights|null
     */
    public function getMyDefaultAdministratorRights(?bool $for_channels = null, ...$args): ChatAdministratorRights|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('getMyDefaultAdministratorRights', $vars), [ChatAdministratorRights::class]);
    }

    /**
     * A JSON-serialized list of special entities that appear in the gift text. It can be specified instead of text_parse_mode. Entities other than “bold”, “italic”, “underline”, “strikethrough”, “spoiler”, and “custom_emoji” are ignored.
     * @param string $gift_id Identifier of the gift
     * @param int|null $user_id Required if chat_id is not specified. Unique identifier of the target user who will receive the gift.
     * @param int|string|null $chat_id Required if user_id is not specified. Unique identifier for the chat or username of the channel (in the format @channelusername) that will receive the gift.
     * @param bool|null $pay_for_upgrade Pass True to pay for the gift upgrade from the bot's balance, thereby making the upgrade free for the receiver
     * @param string|null $text Text that will be shown along with the gift; 0-128 characters
     * @param string|null $text_parse_mode Mode for parsing entities in the text. See formatting options for more details. Entities other than “bold”, “italic”, “underline”, “strikethrough”, “spoiler”, and “custom_emoji” are ignored.
     * @param array<\MemoGram\Api\Types\MessageEntity>|null $text_entities A JSON-serialized list of special entities that appear in the gift text. It can be specified instead of text_parse_mode. Entities other than “bold”, “italic”, “underline”, “strikethrough”, “spoiler”, and “custom_emoji” are ignored.
     * @return true|null
     */
    public function getAvailableGifts(string $gift_id, ?int $user_id = null, int|string|null $chat_id = null, ?bool $pay_for_upgrade = null, ?string $text = null, ?string $text_parse_mode = null, ?array $text_entities = null, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('getAvailableGifts', $vars), ['true']);
    }

    /**
     * A JSON-serialized list of special entities that appear in the gift text. It can be specified instead of text_parse_mode. Entities other than “bold”, “italic”, “underline”, “strikethrough”, “spoiler”, and “custom_emoji” are ignored.
     * @param string $gift_id Identifier of the gift
     * @param int|null $user_id Required if chat_id is not specified. Unique identifier of the target user who will receive the gift.
     * @param int|string|null $chat_id Required if user_id is not specified. Unique identifier for the chat or username of the channel (in the format @channelusername) that will receive the gift.
     * @param bool|null $pay_for_upgrade Pass True to pay for the gift upgrade from the bot's balance, thereby making the upgrade free for the receiver
     * @param string|null $text Text that will be shown along with the gift; 0-128 characters
     * @param string|null $text_parse_mode Mode for parsing entities in the text. See formatting options for more details. Entities other than “bold”, “italic”, “underline”, “strikethrough”, “spoiler”, and “custom_emoji” are ignored.
     * @param array<\MemoGram\Api\Types\MessageEntity>|null $text_entities A JSON-serialized list of special entities that appear in the gift text. It can be specified instead of text_parse_mode. Entities other than “bold”, “italic”, “underline”, “strikethrough”, “spoiler”, and “custom_emoji” are ignored.
     * @return true|null
     */
    public function sendGift(string $gift_id, ?int $user_id = null, int|string|null $chat_id = null, ?bool $pay_for_upgrade = null, ?string $text = null, ?string $text_parse_mode = null, ?array $text_entities = null, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('sendGift', $vars), ['true']);
    }

    /**
     * A JSON-serialized list of special entities that appear in the gift text. It can be specified instead of text_parse_mode. Entities other than “bold”, “italic”, “underline”, “strikethrough”, “spoiler”, and “custom_emoji” are ignored.
     * @param int $user_id Unique identifier of the target user who will receive a Telegram Premium subscription
     * @param int $month_count Number of months the Telegram Premium subscription will be active for the user; must be one of 3, 6, or 12
     * @param int $star_count Number of Telegram Stars to pay for the Telegram Premium subscription; must be 1000 for 3 months, 1500 for 6 months, and 2500 for 12 months
     * @param string|null $text Text that will be shown along with the service message about the subscription; 0-128 characters
     * @param string|null $text_parse_mode Mode for parsing entities in the text. See formatting options for more details. Entities other than “bold”, “italic”, “underline”, “strikethrough”, “spoiler”, and “custom_emoji” are ignored.
     * @param array<\MemoGram\Api\Types\MessageEntity>|null $text_entities A JSON-serialized list of special entities that appear in the gift text. It can be specified instead of text_parse_mode. Entities other than “bold”, “italic”, “underline”, “strikethrough”, “spoiler”, and “custom_emoji” are ignored.
     * @return true|null
     */
    public function giftPremiumSubscription(int $user_id, int $month_count, int $star_count, ?string $text = null, ?string $text_parse_mode = null, ?array $text_entities = null, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('giftPremiumSubscription', $vars), ['true']);
    }

    /**
     * Custom description for the verification; 0-70 characters. Must be empty if the organization isn't allowed to provide a custom verification description.
     * @param int $user_id Unique identifier of the target user
     * @param string|null $custom_description Custom description for the verification; 0-70 characters. Must be empty if the organization isn't allowed to provide a custom verification description.
     * @return true|null
     */
    public function verifyUser(int $user_id, ?string $custom_description = null, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('verifyUser', $vars), ['true']);
    }

    /**
     * Custom description for the verification; 0-70 characters. Must be empty if the organization isn't allowed to provide a custom verification description.
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername). Channel direct messages chats can't be verified.
     * @param string|null $custom_description Custom description for the verification; 0-70 characters. Must be empty if the organization isn't allowed to provide a custom verification description.
     * @return true|null
     */
    public function verifyChat(int|string $chat_id, ?string $custom_description = null, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('verifyChat', $vars), ['true']);
    }

    /**
     * Unique identifier of the target user
     * @param int $user_id Unique identifier of the target user
     * @return true|null
     */
    public function removeUserVerification(int $user_id, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('removeUserVerification', $vars), ['true']);
    }

    /**
     * Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @return true|null
     */
    public function removeChatVerification(int|string $chat_id, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('removeChatVerification', $vars), ['true']);
    }

    /**
     * Unique identifier of the message to mark as read
     * @param string $business_connection_id Unique identifier of the business connection on behalf of which to read the message
     * @param int $chat_id Unique identifier of the chat in which the message was received. The chat must have been active in the last 24 hours.
     * @param int $message_id Unique identifier of the message to mark as read
     * @return true|null
     */
    public function readBusinessMessage(string $business_connection_id, int $chat_id, int $message_id, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('readBusinessMessage', $vars), ['true']);
    }

    /**
     * A JSON-serialized list of 1-100 identifiers of messages to delete. All messages must be from the same chat. See deleteMessage for limitations on which messages can be deleted
     * @param string $business_connection_id Unique identifier of the business connection on behalf of which to delete the messages
     * @param array<\MemoGram\Api\Types\int> $message_ids A JSON-serialized list of 1-100 identifiers of messages to delete. All messages must be from the same chat. See deleteMessage for limitations on which messages can be deleted
     * @return true|null
     */
    public function deleteBusinessMessages(string $business_connection_id, array $message_ids, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('deleteBusinessMessages', $vars), ['true']);
    }

    /**
     * The new value of the last name for the business account; 0-64 characters
     * @param string $business_connection_id Unique identifier of the business connection
     * @param string $first_name The new value of the first name for the business account; 1-64 characters
     * @param string|null $last_name The new value of the last name for the business account; 0-64 characters
     * @return true|null
     */
    public function setBusinessAccountName(string $business_connection_id, string $first_name, ?string $last_name = null, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('setBusinessAccountName', $vars), ['true']);
    }

    /**
     * The new value of the username for the business account; 0-32 characters
     * @param string $business_connection_id Unique identifier of the business connection
     * @param string|null $username The new value of the username for the business account; 0-32 characters
     * @return true|null
     */
    public function setBusinessAccountUsername(string $business_connection_id, ?string $username = null, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('setBusinessAccountUsername', $vars), ['true']);
    }

    /**
     * The new value of the bio for the business account; 0-140 characters
     * @param string $business_connection_id Unique identifier of the business connection
     * @param string|null $bio The new value of the bio for the business account; 0-140 characters
     * @return true|null
     */
    public function setBusinessAccountBio(string $business_connection_id, ?string $bio = null, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('setBusinessAccountBio', $vars), ['true']);
    }

    /**
     * Pass True to set the public photo, which will be visible even if the main photo is hidden by the business account's privacy settings. An account can have only one public photo.
     * @param string $business_connection_id Unique identifier of the business connection
     * @param InputProfilePhoto $photo The new profile photo to set
     * @param bool|null $is_public Pass True to set the public photo, which will be visible even if the main photo is hidden by the business account's privacy settings. An account can have only one public photo.
     * @return true|null
     */
    public function setBusinessAccountProfilePhoto(string $business_connection_id, InputProfilePhotoStatic|InputProfilePhotoAnimated $photo, ?bool $is_public = null, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('setBusinessAccountProfilePhoto', $vars), ['true']);
    }

    /**
     * Pass True to remove the public photo, which is visible even if the main photo is hidden by the business account's privacy settings. After the main photo is removed, the previous profile photo (if present) becomes the main photo.
     * @param string $business_connection_id Unique identifier of the business connection
     * @param bool|null $is_public Pass True to remove the public photo, which is visible even if the main photo is hidden by the business account's privacy settings. After the main photo is removed, the previous profile photo (if present) becomes the main photo.
     * @return true|null
     */
    public function removeBusinessAccountProfilePhoto(string $business_connection_id, ?bool $is_public = null, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('removeBusinessAccountProfilePhoto', $vars), ['true']);
    }

    /**
     * Types of gifts accepted by the business account
     * @param string $business_connection_id Unique identifier of the business connection
     * @param bool $show_gift_button Pass True, if a button for sending a gift to the user or by the business account must always be shown in the input field
     * @param AcceptedGiftTypes $accepted_gift_types Types of gifts accepted by the business account
     * @return true|null
     */
    public function setBusinessAccountGiftSettings(string $business_connection_id, bool $show_gift_button, AcceptedGiftTypes $accepted_gift_types, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('setBusinessAccountGiftSettings', $vars), ['true']);
    }

    /**
     * Unique identifier of the business connection
     * @param string $business_connection_id Unique identifier of the business connection
     * @return int|null
     */
    public function getBusinessAccountStarBalance(string $business_connection_id, ...$args): int|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('getBusinessAccountStarBalance', $vars), ['int']);
    }

    /**
     * Number of Telegram Stars to transfer; 1-10000
     * @param string $business_connection_id Unique identifier of the business connection
     * @param int $star_count Number of Telegram Stars to transfer; 1-10000
     * @return true|null
     */
    public function transferBusinessAccountStars(string $business_connection_id, int $star_count, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('transferBusinessAccountStars', $vars), ['true']);
    }

    /**
     * The maximum number of gifts to be returned; 1-100. Defaults to 100
     * @param string $business_connection_id Unique identifier of the business connection
     * @param bool|null $exclude_unsaved Pass True to exclude gifts that aren't saved to the account's profile page
     * @param bool|null $exclude_saved Pass True to exclude gifts that are saved to the account's profile page
     * @param bool|null $exclude_unlimited Pass True to exclude gifts that can be purchased an unlimited number of times
     * @param bool|null $exclude_limited Pass True to exclude gifts that can be purchased a limited number of times
     * @param bool|null $exclude_unique Pass True to exclude unique gifts
     * @param bool|null $sort_by_price Pass True to sort results by gift price instead of send date. Sorting is applied before pagination.
     * @param string|null $offset Offset of the first entry to return as received from the previous request; use empty string to get the first chunk of results
     * @param int|null $limit The maximum number of gifts to be returned; 1-100. Defaults to 100
     * @return mixed
     */
    public function getBusinessAccountGifts(string $business_connection_id, ?bool $exclude_unsaved = null, ?bool $exclude_saved = null, ?bool $exclude_unlimited = null, ?bool $exclude_limited = null, ?bool $exclude_unique = null, ?bool $sort_by_price = null, ?string $offset = null, ?int $limit = null, ...$args): mixed
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('getBusinessAccountGifts', $vars), ['mixed']);
    }

    /**
     * Unique identifier of the regular gift that should be converted to Telegram Stars
     * @param string $business_connection_id Unique identifier of the business connection
     * @param string $owned_gift_id Unique identifier of the regular gift that should be converted to Telegram Stars
     * @return true|null
     */
    public function convertGiftToStars(string $business_connection_id, string $owned_gift_id, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('convertGiftToStars', $vars), ['true']);
    }

    /**
     * The amount of Telegram Stars that will be paid for the upgrade from the business account balance. If gift.prepaid_upgrade_star_count > 0, then pass 0, otherwise, the can_transfer_stars business bot right is required and gift.upgrade_star_count must be passed.
     * @param string $business_connection_id Unique identifier of the business connection
     * @param string $owned_gift_id Unique identifier of the regular gift that should be upgraded to a unique one
     * @param bool|null $keep_original_details Pass True to keep the original gift text, sender and receiver in the upgraded gift
     * @param int|null $star_count The amount of Telegram Stars that will be paid for the upgrade from the business account balance. If gift.prepaid_upgrade_star_count > 0, then pass 0, otherwise, the can_transfer_stars business bot right is required and gift.upgrade_star_count must be passed.
     * @return true|null
     */
    public function upgradeGift(string $business_connection_id, string $owned_gift_id, ?bool $keep_original_details = null, ?int $star_count = null, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('upgradeGift', $vars), ['true']);
    }

    /**
     * The amount of Telegram Stars that will be paid for the transfer from the business account balance. If positive, then the can_transfer_stars business bot right is required.
     * @param string $business_connection_id Unique identifier of the business connection
     * @param string $owned_gift_id Unique identifier of the regular gift that should be transferred
     * @param int $new_owner_chat_id Unique identifier of the chat which will own the gift. The chat must be active in the last 24 hours.
     * @param int|null $star_count The amount of Telegram Stars that will be paid for the transfer from the business account balance. If positive, then the can_transfer_stars business bot right is required.
     * @return true|null
     */
    public function transferGift(string $business_connection_id, string $owned_gift_id, int $new_owner_chat_id, ?int $star_count = null, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('transferGift', $vars), ['true']);
    }

    /**
     * Pass True if the content of the story must be protected from forwarding and screenshotting
     * @param string $business_connection_id Unique identifier of the business connection
     * @param InputStoryContent $content Content of the story
     * @param int $active_period Period after which the story is moved to the archive, in seconds; must be one of 6 * 3600, 12 * 3600, 86400, or 2 * 86400
     * @param string|null $caption Caption of the story, 0-2048 characters after entities parsing
     * @param string|null $parse_mode Mode for parsing entities in the story caption. See formatting options for more details.
     * @param array<\MemoGram\Api\Types\MessageEntity>|null $caption_entities A JSON-serialized list of special entities that appear in the caption, which can be specified instead of parse_mode
     * @param array<\MemoGram\Api\Types\StoryArea>|null $areas A JSON-serialized list of clickable areas to be shown on the story
     * @param bool|null $post_to_chat_page Pass True to keep the story accessible after it expires
     * @param bool|null $protect_content Pass True if the content of the story must be protected from forwarding and screenshotting
     * @return Story|null
     */
    public function postStory(string $business_connection_id, InputStoryContentPhoto|InputStoryContentVideo $content, int $active_period, ?string $caption = null, ?string $parse_mode = null, ?array $caption_entities = null, ?array $areas = null, ?bool $post_to_chat_page = null, ?bool $protect_content = null, ...$args): Story|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('postStory', $vars), [Story::class]);
    }

    /**
     * A JSON-serialized list of clickable areas to be shown on the story
     * @param string $business_connection_id Unique identifier of the business connection
     * @param int $story_id Unique identifier of the story to edit
     * @param InputStoryContent $content Content of the story
     * @param string|null $caption Caption of the story, 0-2048 characters after entities parsing
     * @param string|null $parse_mode Mode for parsing entities in the story caption. See formatting options for more details.
     * @param array<\MemoGram\Api\Types\MessageEntity>|null $caption_entities A JSON-serialized list of special entities that appear in the caption, which can be specified instead of parse_mode
     * @param array<\MemoGram\Api\Types\StoryArea>|null $areas A JSON-serialized list of clickable areas to be shown on the story
     * @return Story|null
     */
    public function editStory(string $business_connection_id, int $story_id, InputStoryContentPhoto|InputStoryContentVideo $content, ?string $caption = null, ?string $parse_mode = null, ?array $caption_entities = null, ?array $areas = null, ...$args): Story|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('editStory', $vars), [Story::class]);
    }

    /**
     * Unique identifier of the story to delete
     * @param string $business_connection_id Unique identifier of the business connection
     * @param int $story_id Unique identifier of the story to delete
     * @return true|null
     */
    public function deleteStory(string $business_connection_id, int $story_id, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('deleteStory', $vars), ['true']);
    }

    /**
     * A JSON-serialized object for an inline keyboard.
     * @param string $text New text of the message, 1-4096 characters after entities parsing
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message to be edited was sent
     * @param int|string|null $chat_id Required if inline_message_id is not specified. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param int|null $message_id Required if inline_message_id is not specified. Identifier of the message to edit
     * @param string|null $inline_message_id Required if chat_id and message_id are not specified. Identifier of the inline message
     * @param string|null $parse_mode Mode for parsing entities in the message text. See formatting options for more details.
     * @param array<\MemoGram\Api\Types\MessageEntity>|null $entities A JSON-serialized list of special entities that appear in message text, which can be specified instead of parse_mode
     * @param LinkPreviewOptions|null $link_preview_options Link preview generation options for the message
     * @param InlineKeyboardMarkup|null $reply_markup A JSON-serialized object for an inline keyboard.
     * @return mixed
     */
    public function editMessageText(string $text, ?string $business_connection_id = null, int|string|null $chat_id = null, ?int $message_id = null, ?string $inline_message_id = null, ?string $parse_mode = null, ?array $entities = null, ?LinkPreviewOptions $link_preview_options = null, ?InlineKeyboardMarkup $reply_markup = null, ...$args): mixed
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('editMessageText', $vars), ['mixed']);
    }

    /**
     * A JSON-serialized object for an inline keyboard.
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message to be edited was sent
     * @param int|string|null $chat_id Required if inline_message_id is not specified. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param int|null $message_id Required if inline_message_id is not specified. Identifier of the message to edit
     * @param string|null $inline_message_id Required if chat_id and message_id are not specified. Identifier of the inline message
     * @param string|null $caption New caption of the message, 0-1024 characters after entities parsing
     * @param string|null $parse_mode Mode for parsing entities in the message caption. See formatting options for more details.
     * @param array<\MemoGram\Api\Types\MessageEntity>|null $caption_entities A JSON-serialized list of special entities that appear in the caption, which can be specified instead of parse_mode
     * @param bool|null $show_caption_above_media Pass True, if the caption must be shown above the message media. Supported only for animation, photo and video messages.
     * @param InlineKeyboardMarkup|null $reply_markup A JSON-serialized object for an inline keyboard.
     * @return mixed
     */
    public function editMessageCaption(?string $business_connection_id = null, int|string|null $chat_id = null, ?int $message_id = null, ?string $inline_message_id = null, ?string $caption = null, ?string $parse_mode = null, ?array $caption_entities = null, ?bool $show_caption_above_media = null, ?InlineKeyboardMarkup $reply_markup = null, ...$args): mixed
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('editMessageCaption', $vars), ['mixed']);
    }

    /**
     * A JSON-serialized object for a new inline keyboard.
     * @param InputMediaPhoto|InputMediaVideo|InputMediaAnimation|InputMediaAudio|InputMediaDocument|array $media A JSON-serialized object for a new media content of the message
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message to be edited was sent
     * @param int|string|null $chat_id Required if inline_message_id is not specified. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param int|null $message_id Required if inline_message_id is not specified. Identifier of the message to edit
     * @param string|null $inline_message_id Required if chat_id and message_id are not specified. Identifier of the inline message
     * @param InlineKeyboardMarkup|null $reply_markup A JSON-serialized object for a new inline keyboard.
     * @return mixed
     */
    public function editMessageMedia(InputMediaPhoto|InputMediaVideo|InputMediaAnimation|InputMediaAudio|InputMediaDocument|array $media, ?string $business_connection_id = null, int|string|null $chat_id = null, ?int $message_id = null, ?string $inline_message_id = null, ?InlineKeyboardMarkup $reply_markup = null, ...$args): mixed
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('editMessageMedia', $vars), ['mixed']);
    }

    /**
     * A JSON-serialized object for a new inline keyboard.
     * @param float $latitude Latitude of new location
     * @param float $longitude Longitude of new location
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message to be edited was sent
     * @param int|string|null $chat_id Required if inline_message_id is not specified. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param int|null $message_id Required if inline_message_id is not specified. Identifier of the message to edit
     * @param string|null $inline_message_id Required if chat_id and message_id are not specified. Identifier of the inline message
     * @param int|null $live_period New period in seconds during which the location can be updated, starting from the message send date. If 0x7FFFFFFF is specified, then the location can be updated forever. Otherwise, the new value must not exceed the current live_period by more than a day, and the live location expiration date must remain within the next 90 days. If not specified, then live_period remains unchanged
     * @param float|null $horizontal_accuracy The radius of uncertainty for the location, measured in meters; 0-1500
     * @param int|null $heading Direction in which the user is moving, in degrees. Must be between 1 and 360 if specified.
     * @param int|null $proximity_alert_radius The maximum distance for proximity alerts about approaching another chat member, in meters. Must be between 1 and 100000 if specified.
     * @param InlineKeyboardMarkup|null $reply_markup A JSON-serialized object for a new inline keyboard.
     * @return mixed
     */
    public function editMessageLiveLocation(float $latitude, float $longitude, ?string $business_connection_id = null, int|string|null $chat_id = null, ?int $message_id = null, ?string $inline_message_id = null, ?int $live_period = null, ?float $horizontal_accuracy = null, ?int $heading = null, ?int $proximity_alert_radius = null, ?InlineKeyboardMarkup $reply_markup = null, ...$args): mixed
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('editMessageLiveLocation', $vars), ['mixed']);
    }

    /**
     * A JSON-serialized object for a new inline keyboard.
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message to be edited was sent
     * @param int|string|null $chat_id Required if inline_message_id is not specified. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param int|null $message_id Required if inline_message_id is not specified. Identifier of the message with live location to stop
     * @param string|null $inline_message_id Required if chat_id and message_id are not specified. Identifier of the inline message
     * @param InlineKeyboardMarkup|null $reply_markup A JSON-serialized object for a new inline keyboard.
     * @return mixed
     */
    public function stopMessageLiveLocation(?string $business_connection_id = null, int|string|null $chat_id = null, ?int $message_id = null, ?string $inline_message_id = null, ?InlineKeyboardMarkup $reply_markup = null, ...$args): mixed
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('stopMessageLiveLocation', $vars), ['mixed']);
    }

    /**
     * A JSON-serialized object for the new inline keyboard for the message
     * @param string $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param int $chat_id Unique identifier for the target chat
     * @param int $message_id Unique identifier for the target message
     * @param InputChecklist $checklist A JSON-serialized object for the new checklist
     * @param InlineKeyboardMarkup|null $reply_markup A JSON-serialized object for the new inline keyboard for the message
     * @return mixed
     */
    public function editMessageChecklist(string $business_connection_id, int $chat_id, int $message_id, InputChecklist $checklist, ?InlineKeyboardMarkup $reply_markup = null, ...$args): mixed
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('editMessageChecklist', $vars), ['mixed']);
    }

    /**
     * A JSON-serialized object for an inline keyboard.
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message to be edited was sent
     * @param int|string|null $chat_id Required if inline_message_id is not specified. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param int|null $message_id Required if inline_message_id is not specified. Identifier of the message to edit
     * @param string|null $inline_message_id Required if chat_id and message_id are not specified. Identifier of the inline message
     * @param InlineKeyboardMarkup|null $reply_markup A JSON-serialized object for an inline keyboard.
     * @return mixed
     */
    public function editMessageReplyMarkup(?string $business_connection_id = null, int|string|null $chat_id = null, ?int $message_id = null, ?string $inline_message_id = null, ?InlineKeyboardMarkup $reply_markup = null, ...$args): mixed
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('editMessageReplyMarkup', $vars), ['mixed']);
    }

    /**
     * A JSON-serialized object for a new message inline keyboard.
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param int $message_id Identifier of the original message with the poll
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message to be edited was sent
     * @param InlineKeyboardMarkup|null $reply_markup A JSON-serialized object for a new message inline keyboard.
     * @return mixed
     */
    public function stopPoll(int|string $chat_id, int $message_id, ?string $business_connection_id = null, ?InlineKeyboardMarkup $reply_markup = null, ...$args): mixed
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('stopPoll', $vars), ['mixed']);
    }

    /**
     * Point in time (Unix timestamp) when the post is expected to be published; omit if the date has already been specified when the suggested post was created. If specified, then the date must be not more than 2678400 seconds (30 days) in the future
     * @param int $chat_id Unique identifier for the target direct messages chat
     * @param int $message_id Identifier of a suggested post message to approve
     * @param int|null $send_date Point in time (Unix timestamp) when the post is expected to be published; omit if the date has already been specified when the suggested post was created. If specified, then the date must be not more than 2678400 seconds (30 days) in the future
     * @return true|null
     */
    public function approveSuggestedPost(int $chat_id, int $message_id, ?int $send_date = null, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('approveSuggestedPost', $vars), ['true']);
    }

    /**
     * Comment for the creator of the suggested post; 0-128 characters
     * @param int $chat_id Unique identifier for the target direct messages chat
     * @param int $message_id Identifier of a suggested post message to decline
     * @param string|null $comment Comment for the creator of the suggested post; 0-128 characters
     * @return true|null
     */
    public function declineSuggestedPost(int $chat_id, int $message_id, ?string $comment = null, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('declineSuggestedPost', $vars), ['true']);
    }

    /**
     * Identifier of the message to delete
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param int $message_id Identifier of the message to delete
     * @return true|null
     */
    public function deleteMessage(int|string $chat_id, int $message_id, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('deleteMessage', $vars), ['true']);
    }

    /**
     * A JSON-serialized list of 1-100 identifiers of messages to delete. See deleteMessage for limitations on which messages can be deleted
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param array<\MemoGram\Api\Types\int> $message_ids A JSON-serialized list of 1-100 identifiers of messages to delete. See deleteMessage for limitations on which messages can be deleted
     * @return true|null
     */
    public function deleteMessages(int|string $chat_id, array $message_ids, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('deleteMessages', $vars), ['true']);
    }

    /**
     * Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param mixed|string $sticker Sticker to send. Pass a file_id as String to send a file that exists on the Telegram servers (recommended), pass an HTTP URL as a String for Telegram to get a .WEBP sticker from the Internet, or upload a new .WEBP, .TGS, or .WEBM sticker using multipart/form-data. More information on Sending Files ». Video and animated stickers can't be sent via an HTTP URL.
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param int|null $direct_messages_topic_id Identifier of the direct messages topic to which the message will be sent; required if the message is sent to a direct messages chat
     * @param string|null $emoji Emoji associated with the sticker; only for just uploaded stickers
     * @param bool|null $disable_notification Sends the message silently. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param bool|null $allow_paid_broadcast Pass True to allow up to 1000 messages per second, ignoring broadcasting limits for a fee of 0.1 Telegram Stars per message. The relevant Stars will be withdrawn from the bot's balance
     * @param string|null $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param SuggestedPostParameters|null $suggested_post_parameters A JSON-serialized object containing the parameters of the suggested post to send; for direct messages chats only. If the message is sent as a reply to another suggested post, then that suggested post is automatically declined.
     * @param ReplyParameters|null $reply_parameters Description of the message to reply to
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
     * @return Message|null
     */
    public function sendSticker(int|string $chat_id, mixed $sticker, ?string $business_connection_id = null, ?int $message_thread_id = null, ?int $direct_messages_topic_id = null, ?string $emoji = null, ?bool $disable_notification = null, ?bool $protect_content = null, ?bool $allow_paid_broadcast = null, ?string $message_effect_id = null, ?SuggestedPostParameters $suggested_post_parameters = null, ?ReplyParameters $reply_parameters = null, InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null, ...$args): Message|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('sendSticker', $vars), [Message::class]);
    }

    /**
     * Name of the sticker set
     * @param string $name Name of the sticker set
     * @return mixed
     */
    public function getStickerSet(string $name, ...$args): mixed
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('getStickerSet', $vars), ['mixed']);
    }

    /**
     * A JSON-serialized list of custom emoji identifiers. At most 200 custom emoji identifiers can be specified.
     * @param array<\MemoGram\Api\Types\string> $custom_emoji_ids A JSON-serialized list of custom emoji identifiers. At most 200 custom emoji identifiers can be specified.
     * @return array<Sticker>|null
     */
    public function getCustomEmojiStickers(array $custom_emoji_ids, ...$args): array|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('getCustomEmojiStickers', $vars), ['array', Sticker::class]);
    }

    /**
     * Format of the sticker, must be one of “static”, “animated”, “video”
     * @param int $user_id User identifier of sticker file owner
     * @param mixed $sticker A file with the sticker in .WEBP, .PNG, .TGS, or .WEBM format. See https://core.telegram.org/stickers for technical requirements. More information on Sending Files »
     * @param string $sticker_format Format of the sticker, must be one of “static”, “animated”, “video”
     * @return File|null
     */
    public function uploadStickerFile(int $user_id, mixed $sticker, string $sticker_format, ...$args): File|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('uploadStickerFile', $vars), [File::class]);
    }

    /**
     * Pass True if stickers in the sticker set must be repainted to the color of text when used in messages, the accent color if used as emoji status, white on chat photos, or another appropriate color based on context; for custom emoji sticker sets only
     * @param int $user_id User identifier of created sticker set owner
     * @param string $name Short name of sticker set, to be used in t.me/addstickers/ URLs (e.g., animals). Can contain only English letters, digits and underscores. Must begin with a letter, can't contain consecutive underscores and must end in "_by_<bot_username>". <bot_username> is case insensitive. 1-64 characters.
     * @param string $title Sticker set title, 1-64 characters
     * @param array<\MemoGram\Api\Types\InputSticker> $stickers A JSON-serialized list of 1-50 initial stickers to be added to the sticker set
     * @param string|null $sticker_type Type of stickers in the set, pass “regular”, “mask”, or “custom_emoji”. By default, a regular sticker set is created.
     * @param bool|null $needs_repainting Pass True if stickers in the sticker set must be repainted to the color of text when used in messages, the accent color if used as emoji status, white on chat photos, or another appropriate color based on context; for custom emoji sticker sets only
     * @return true|null
     */
    public function createNewStickerSet(int $user_id, string $name, string $title, array $stickers, ?string $sticker_type = null, ?bool $needs_repainting = null, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('createNewStickerSet', $vars), ['true']);
    }

    /**
     * A JSON-serialized object with information about the added sticker. If exactly the same sticker had already been added to the set, then the set isn't changed.
     * @param int $user_id User identifier of sticker set owner
     * @param string $name Sticker set name
     * @param InputSticker $sticker A JSON-serialized object with information about the added sticker. If exactly the same sticker had already been added to the set, then the set isn't changed.
     * @return true|null
     */
    public function addStickerToSet(int $user_id, string $name, InputSticker $sticker, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('addStickerToSet', $vars), ['true']);
    }

    /**
     * New sticker position in the set, zero-based
     * @param string $sticker File identifier of the sticker
     * @param int $position New sticker position in the set, zero-based
     * @return true|null
     */
    public function setStickerPositionInSet(string $sticker, int $position, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('setStickerPositionInSet', $vars), ['true']);
    }

    /**
     * File identifier of the sticker
     * @param string $sticker File identifier of the sticker
     * @return true|null
     */
    public function deleteStickerFromSet(string $sticker, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('deleteStickerFromSet', $vars), ['true']);
    }

    /**
     * A JSON-serialized object with information about the added sticker. If exactly the same sticker had already been added to the set, then the set remains unchanged.
     * @param int $user_id User identifier of the sticker set owner
     * @param string $name Sticker set name
     * @param string $old_sticker File identifier of the replaced sticker
     * @param InputSticker $sticker A JSON-serialized object with information about the added sticker. If exactly the same sticker had already been added to the set, then the set remains unchanged.
     * @return true|null
     */
    public function replaceStickerInSet(int $user_id, string $name, string $old_sticker, InputSticker $sticker, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('replaceStickerInSet', $vars), ['true']);
    }

    /**
     * A JSON-serialized list of 1-20 emoji associated with the sticker
     * @param string $sticker File identifier of the sticker
     * @param array<\MemoGram\Api\Types\string> $emoji_list A JSON-serialized list of 1-20 emoji associated with the sticker
     * @return true|null
     */
    public function setStickerEmojiList(string $sticker, array $emoji_list, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('setStickerEmojiList', $vars), ['true']);
    }

    /**
     * A JSON-serialized list of 0-20 search keywords for the sticker with total length of up to 64 characters
     * @param string $sticker File identifier of the sticker
     * @param array<\MemoGram\Api\Types\string>|null $keywords A JSON-serialized list of 0-20 search keywords for the sticker with total length of up to 64 characters
     * @return true|null
     */
    public function setStickerKeywords(string $sticker, ?array $keywords = null, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('setStickerKeywords', $vars), ['true']);
    }

    /**
     * A JSON-serialized object with the position where the mask should be placed on faces. Omit the parameter to remove the mask position.
     * @param string $sticker File identifier of the sticker
     * @param MaskPosition|null $mask_position A JSON-serialized object with the position where the mask should be placed on faces. Omit the parameter to remove the mask position.
     * @return true|null
     */
    public function setStickerMaskPosition(string $sticker, ?MaskPosition $mask_position = null, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('setStickerMaskPosition', $vars), ['true']);
    }

    /**
     * Sticker set title, 1-64 characters
     * @param string $name Sticker set name
     * @param string $title Sticker set title, 1-64 characters
     * @return true|null
     */
    public function setStickerSetTitle(string $name, string $title, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('setStickerSetTitle', $vars), ['true']);
    }

    /**
     * Format of the thumbnail, must be one of “static” for a .WEBP or .PNG image, “animated” for a .TGS animation, or “video” for a .WEBM video
     * @param string $name Sticker set name
     * @param int $user_id User identifier of the sticker set owner
     * @param string $format Format of the thumbnail, must be one of “static” for a .WEBP or .PNG image, “animated” for a .TGS animation, or “video” for a .WEBM video
     * @param mixed|string|null $thumbnail A .WEBP or .PNG image with the thumbnail, must be up to 128 kilobytes in size and have a width and height of exactly 100px, or a .TGS animation with a thumbnail up to 32 kilobytes in size (see https://core.telegram.org/stickers#animation-requirements for animated sticker technical requirements), or a .WEBM video with the thumbnail up to 32 kilobytes in size; see https://core.telegram.org/stickers#video-requirements for video sticker technical requirements. Pass a file_id as a String to send a file that already exists on the Telegram servers, pass an HTTP URL as a String for Telegram to get a file from the Internet, or upload a new one using multipart/form-data. More information on Sending Files ». Animated and video sticker set thumbnails can't be uploaded via HTTP URL. If omitted, then the thumbnail is dropped and the first sticker is used as the thumbnail.
     * @return true|null
     */
    public function setStickerSetThumbnail(string $name, int $user_id, string $format, mixed $thumbnail = null, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('setStickerSetThumbnail', $vars), ['true']);
    }

    /**
     * Custom emoji identifier of a sticker from the sticker set; pass an empty string to drop the thumbnail and use the first sticker as the thumbnail.
     * @param string $name Sticker set name
     * @param string|null $custom_emoji_id Custom emoji identifier of a sticker from the sticker set; pass an empty string to drop the thumbnail and use the first sticker as the thumbnail.
     * @return true|null
     */
    public function setCustomEmojiStickerSetThumbnail(string $name, ?string $custom_emoji_id = null, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('setCustomEmojiStickerSetThumbnail', $vars), ['true']);
    }

    /**
     * Sticker set name
     * @param string $name Sticker set name
     * @return true|null
     */
    public function deleteStickerSet(string $name, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('deleteStickerSet', $vars), ['true']);
    }

    /**
     * A JSON-serialized object describing a button to be shown above inline query results
     * @param string $inline_query_id Unique identifier for the answered query
     * @param array<\MemoGram\Api\Types\InlineQueryResult> $results A JSON-serialized array of results for the inline query
     * @param int|null $cache_time The maximum amount of time in seconds that the result of the inline query may be cached on the server. Defaults to 300.
     * @param bool|null $is_personal Pass True if results may be cached on the server side only for the user that sent the query. By default, results may be returned to any user who sends the same query.
     * @param string|null $next_offset Pass the offset that a client should send in the next query with the same text to receive more results. Pass an empty string if there are no more results or if you don't support pagination. Offset length can't exceed 64 bytes.
     * @param InlineQueryResultsButton|null $button A JSON-serialized object describing a button to be shown above inline query results
     * @return mixed
     */
    public function answerInlineQuery(string $inline_query_id, array $results, ?int $cache_time = null, ?bool $is_personal = null, ?string $next_offset = null, ?InlineQueryResultsButton $button = null, ...$args): mixed
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('answerInlineQuery', $vars), ['mixed']);
    }

    /**
     * A JSON-serialized object describing the message to be sent
     * @param string $web_app_query_id Unique identifier for the query to be answered
     * @param InlineQueryResult $result A JSON-serialized object describing the message to be sent
     * @return mixed
     */
    public function answerWebAppQuery(string $web_app_query_id, InlineQueryResult $result, ...$args): mixed
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('answerWebAppQuery', $vars), ['mixed']);
    }

    /**
     * Pass True if the message can be sent to channel chats
     * @param int $user_id Unique identifier of the target user that can use the prepared message
     * @param InlineQueryResult $result A JSON-serialized object describing the message to be sent
     * @param bool|null $allow_user_chats Pass True if the message can be sent to private chats with users
     * @param bool|null $allow_bot_chats Pass True if the message can be sent to private chats with bots
     * @param bool|null $allow_group_chats Pass True if the message can be sent to group and supergroup chats
     * @param bool|null $allow_channel_chats Pass True if the message can be sent to channel chats
     * @return PreparedInlineMessage|null
     */
    public function savePreparedInlineMessage(int $user_id, InlineQueryResult $result, ?bool $allow_user_chats = null, ?bool $allow_bot_chats = null, ?bool $allow_group_chats = null, ?bool $allow_channel_chats = null, ...$args): PreparedInlineMessage|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('savePreparedInlineMessage', $vars), [PreparedInlineMessage::class]);
    }

    /**
     * A JSON-serialized object for an inline keyboard. If empty, one 'Pay total price' button will be shown. If not empty, the first button must be a Pay button.
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param string $title Product name, 1-32 characters
     * @param string $description Product description, 1-255 characters
     * @param string $payload Bot-defined invoice payload, 1-128 bytes. This will not be displayed to the user, use it for your internal processes.
     * @param string $currency Three-letter ISO 4217 currency code, see more on currencies. Pass “XTR” for payments in Telegram Stars.
     * @param array<\MemoGram\Api\Types\LabeledPrice> $prices Price breakdown, a JSON-serialized list of components (e.g. product price, tax, discount, delivery cost, delivery tax, bonus, etc.). Must contain exactly one item for payments in Telegram Stars.
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param int|null $direct_messages_topic_id Identifier of the direct messages topic to which the message will be sent; required if the message is sent to a direct messages chat
     * @param string|null $provider_token Payment provider token, obtained via @BotFather. Pass an empty string for payments in Telegram Stars.
     * @param int|null $max_tip_amount The maximum accepted amount for tips in the smallest units of the currency (integer, not float/double). For example, for a maximum tip of US$ 1.45 pass max_tip_amount = 145. See the exp parameter in currencies.json, it shows the number of digits past the decimal point for each currency (2 for the majority of currencies). Defaults to 0. Not supported for payments in Telegram Stars.
     * @param array<\MemoGram\Api\Types\int>|null $suggested_tip_amounts A JSON-serialized array of suggested amounts of tips in the smallest units of the currency (integer, not float/double). At most 4 suggested tip amounts can be specified. The suggested tip amounts must be positive, passed in a strictly increased order and must not exceed max_tip_amount.
     * @param string|null $start_parameter Unique deep-linking parameter. If left empty, forwarded copies of the sent message will have a Pay button, allowing multiple users to pay directly from the forwarded message, using the same invoice. If non-empty, forwarded copies of the sent message will have a URL button with a deep link to the bot (instead of a Pay button), with the value used as the start parameter
     * @param string|null $provider_data JSON-serialized data about the invoice, which will be shared with the payment provider. A detailed description of required fields should be provided by the payment provider.
     * @param string|null $photo_url URL of the product photo for the invoice. Can be a photo of the goods or a marketing image for a service. People like it better when they see what they are paying for.
     * @param int|null $photo_size Photo size in bytes
     * @param int|null $photo_width Photo width
     * @param int|null $photo_height Photo height
     * @param bool|null $need_name Pass True if you require the user's full name to complete the order. Ignored for payments in Telegram Stars.
     * @param bool|null $need_phone_number Pass True if you require the user's phone number to complete the order. Ignored for payments in Telegram Stars.
     * @param bool|null $need_email Pass True if you require the user's email address to complete the order. Ignored for payments in Telegram Stars.
     * @param bool|null $need_shipping_address Pass True if you require the user's shipping address to complete the order. Ignored for payments in Telegram Stars.
     * @param bool|null $send_phone_number_to_provider Pass True if the user's phone number should be sent to the provider. Ignored for payments in Telegram Stars.
     * @param bool|null $send_email_to_provider Pass True if the user's email address should be sent to the provider. Ignored for payments in Telegram Stars.
     * @param bool|null $is_flexible Pass True if the final price depends on the shipping method. Ignored for payments in Telegram Stars.
     * @param bool|null $disable_notification Sends the message silently. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param bool|null $allow_paid_broadcast Pass True to allow up to 1000 messages per second, ignoring broadcasting limits for a fee of 0.1 Telegram Stars per message. The relevant Stars will be withdrawn from the bot's balance
     * @param string|null $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param SuggestedPostParameters|null $suggested_post_parameters A JSON-serialized object containing the parameters of the suggested post to send; for direct messages chats only. If the message is sent as a reply to another suggested post, then that suggested post is automatically declined.
     * @param ReplyParameters|null $reply_parameters Description of the message to reply to
     * @param InlineKeyboardMarkup|null $reply_markup A JSON-serialized object for an inline keyboard. If empty, one 'Pay total price' button will be shown. If not empty, the first button must be a Pay button.
     * @return Message|null
     */
    public function sendInvoice(int|string $chat_id, string $title, string $description, string $payload, string $currency, array $prices, ?int $message_thread_id = null, ?int $direct_messages_topic_id = null, ?string $provider_token = null, ?int $max_tip_amount = null, ?array $suggested_tip_amounts = null, ?string $start_parameter = null, ?string $provider_data = null, ?string $photo_url = null, ?int $photo_size = null, ?int $photo_width = null, ?int $photo_height = null, ?bool $need_name = null, ?bool $need_phone_number = null, ?bool $need_email = null, ?bool $need_shipping_address = null, ?bool $send_phone_number_to_provider = null, ?bool $send_email_to_provider = null, ?bool $is_flexible = null, ?bool $disable_notification = null, ?bool $protect_content = null, ?bool $allow_paid_broadcast = null, ?string $message_effect_id = null, ?SuggestedPostParameters $suggested_post_parameters = null, ?ReplyParameters $reply_parameters = null, ?InlineKeyboardMarkup $reply_markup = null, ...$args): Message|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('sendInvoice', $vars), [Message::class]);
    }

    /**
     * Pass True if the final price depends on the shipping method. Ignored for payments in Telegram Stars.
     * @param string $title Product name, 1-32 characters
     * @param string $description Product description, 1-255 characters
     * @param string $payload Bot-defined invoice payload, 1-128 bytes. This will not be displayed to the user, use it for your internal processes.
     * @param string $currency Three-letter ISO 4217 currency code, see more on currencies. Pass “XTR” for payments in Telegram Stars.
     * @param array<\MemoGram\Api\Types\LabeledPrice> $prices Price breakdown, a JSON-serialized list of components (e.g. product price, tax, discount, delivery cost, delivery tax, bonus, etc.). Must contain exactly one item for payments in Telegram Stars.
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the link will be created. For payments in Telegram Stars only.
     * @param string|null $provider_token Payment provider token, obtained via @BotFather. Pass an empty string for payments in Telegram Stars.
     * @param int|null $subscription_period The number of seconds the subscription will be active for before the next payment. The currency must be set to “XTR” (Telegram Stars) if the parameter is used. Currently, it must always be 2592000 (30 days) if specified. Any number of subscriptions can be active for a given bot at the same time, including multiple concurrent subscriptions from the same user. Subscription price must no exceed 10000 Telegram Stars.
     * @param int|null $max_tip_amount The maximum accepted amount for tips in the smallest units of the currency (integer, not float/double). For example, for a maximum tip of US$ 1.45 pass max_tip_amount = 145. See the exp parameter in currencies.json, it shows the number of digits past the decimal point for each currency (2 for the majority of currencies). Defaults to 0. Not supported for payments in Telegram Stars.
     * @param array<\MemoGram\Api\Types\int>|null $suggested_tip_amounts A JSON-serialized array of suggested amounts of tips in the smallest units of the currency (integer, not float/double). At most 4 suggested tip amounts can be specified. The suggested tip amounts must be positive, passed in a strictly increased order and must not exceed max_tip_amount.
     * @param string|null $provider_data JSON-serialized data about the invoice, which will be shared with the payment provider. A detailed description of required fields should be provided by the payment provider.
     * @param string|null $photo_url URL of the product photo for the invoice. Can be a photo of the goods or a marketing image for a service.
     * @param int|null $photo_size Photo size in bytes
     * @param int|null $photo_width Photo width
     * @param int|null $photo_height Photo height
     * @param bool|null $need_name Pass True if you require the user's full name to complete the order. Ignored for payments in Telegram Stars.
     * @param bool|null $need_phone_number Pass True if you require the user's phone number to complete the order. Ignored for payments in Telegram Stars.
     * @param bool|null $need_email Pass True if you require the user's email address to complete the order. Ignored for payments in Telegram Stars.
     * @param bool|null $need_shipping_address Pass True if you require the user's shipping address to complete the order. Ignored for payments in Telegram Stars.
     * @param bool|null $send_phone_number_to_provider Pass True if the user's phone number should be sent to the provider. Ignored for payments in Telegram Stars.
     * @param bool|null $send_email_to_provider Pass True if the user's email address should be sent to the provider. Ignored for payments in Telegram Stars.
     * @param bool|null $is_flexible Pass True if the final price depends on the shipping method. Ignored for payments in Telegram Stars.
     * @return string|null
     */
    public function createInvoiceLink(string $title, string $description, string $payload, string $currency, array $prices, ?string $business_connection_id = null, ?string $provider_token = null, ?int $subscription_period = null, ?int $max_tip_amount = null, ?array $suggested_tip_amounts = null, ?string $provider_data = null, ?string $photo_url = null, ?int $photo_size = null, ?int $photo_width = null, ?int $photo_height = null, ?bool $need_name = null, ?bool $need_phone_number = null, ?bool $need_email = null, ?bool $need_shipping_address = null, ?bool $send_phone_number_to_provider = null, ?bool $send_email_to_provider = null, ?bool $is_flexible = null, ...$args): string|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('createInvoiceLink', $vars), ['string']);
    }

    /**
     * Required if ok is False. Error message in human readable form that explains why it is impossible to complete the order (e.g. “Sorry, delivery to your desired address is unavailable”). Telegram will display this message to the user.
     * @param string $shipping_query_id Unique identifier for the query to be answered
     * @param bool $ok Pass True if delivery to the specified address is possible and False if there are any problems (for example, if delivery to the specified address is not possible)
     * @param array<\MemoGram\Api\Types\ShippingOption>|null $shipping_options Required if ok is True. A JSON-serialized array of available shipping options.
     * @param string|null $error_message Required if ok is False. Error message in human readable form that explains why it is impossible to complete the order (e.g. “Sorry, delivery to your desired address is unavailable”). Telegram will display this message to the user.
     * @return mixed
     */
    public function answerShippingQuery(string $shipping_query_id, bool $ok, ?array $shipping_options = null, ?string $error_message = null, ...$args): mixed
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('answerShippingQuery', $vars), ['mixed']);
    }

    /**
     * Required if ok is False. Error message in human readable form that explains the reason for failure to proceed with the checkout (e.g. "Sorry, somebody just bought the last of our amazing black T-shirts while you were busy filling out your payment details. Please choose a different color or garment!"). Telegram will display this message to the user.
     * @param string $pre_checkout_query_id Unique identifier for the query to be answered
     * @param bool $ok Specify True if everything is alright (goods are available, etc.) and the bot is ready to proceed with the order. Use False if there are any problems.
     * @param string|null $error_message Required if ok is False. Error message in human readable form that explains the reason for failure to proceed with the checkout (e.g. "Sorry, somebody just bought the last of our amazing black T-shirts while you were busy filling out your payment details. Please choose a different color or garment!"). Telegram will display this message to the user.
     * @return mixed
     */
    public function answerPreCheckoutQuery(string $pre_checkout_query_id, bool $ok, ?string $error_message = null, ...$args): mixed
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('answerPreCheckoutQuery', $vars), ['mixed']);
    }

    /**
     * The maximum number of transactions to be retrieved. Values between 1-100 are accepted. Defaults to 100.
     * @param int|null $offset Number of transactions to skip in the response
     * @param int|null $limit The maximum number of transactions to be retrieved. Values between 1-100 are accepted. Defaults to 100.
     * @return mixed
     */
    public function getMyStarBalance(?int $offset = null, ?int $limit = null, ...$args): mixed
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('getMyStarBalance', $vars), ['mixed']);
    }

    /**
     * The maximum number of transactions to be retrieved. Values between 1-100 are accepted. Defaults to 100.
     * @param int|null $offset Number of transactions to skip in the response
     * @param int|null $limit The maximum number of transactions to be retrieved. Values between 1-100 are accepted. Defaults to 100.
     * @return mixed
     */
    public function getStarTransactions(?int $offset = null, ?int $limit = null, ...$args): mixed
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('getStarTransactions', $vars), ['mixed']);
    }

    /**
     * Telegram payment identifier
     * @param int $user_id Identifier of the user whose payment will be refunded
     * @param string $telegram_payment_charge_id Telegram payment identifier
     * @return true|null
     */
    public function refundStarPayment(int $user_id, string $telegram_payment_charge_id, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('refundStarPayment', $vars), ['true']);
    }

    /**
     * Pass True to cancel extension of the user subscription; the subscription must be active up to the end of the current subscription period. Pass False to allow the user to re-enable a subscription that was previously canceled by the bot.
     * @param int $user_id Identifier of the user whose subscription will be edited
     * @param string $telegram_payment_charge_id Telegram payment identifier for the subscription
     * @param bool $is_canceled Pass True to cancel extension of the user subscription; the subscription must be active up to the end of the current subscription period. Pass False to allow the user to re-enable a subscription that was previously canceled by the bot.
     * @return true|null
     */
    public function editUserStarSubscription(int $user_id, string $telegram_payment_charge_id, bool $is_canceled, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('editUserStarSubscription', $vars), ['true']);
    }

    /**
     * A JSON-serialized array describing the errors
     * @param int $user_id User identifier
     * @param array<\MemoGram\Api\Types\PassportElementError> $errors A JSON-serialized array describing the errors
     * @return true|null
     */
    public function setPassportDataErrors(int $user_id, array $errors, ...$args): true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('setPassportDataErrors', $vars), ['true']);
    }

    /**
     * A JSON-serialized object for an inline keyboard. If empty, one 'Play game_title' button will be shown. If not empty, the first button must launch the game.
     * @param int $chat_id Unique identifier for the target chat. Games can't be sent to channel direct messages chats and channel chats.
     * @param string $game_short_name Short name of the game, serves as the unique identifier for the game. Set up your games via @BotFather.
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param bool|null $disable_notification Sends the message silently. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param bool|null $allow_paid_broadcast Pass True to allow up to 1000 messages per second, ignoring broadcasting limits for a fee of 0.1 Telegram Stars per message. The relevant Stars will be withdrawn from the bot's balance
     * @param string|null $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param ReplyParameters|null $reply_parameters Description of the message to reply to
     * @param InlineKeyboardMarkup|null $reply_markup A JSON-serialized object for an inline keyboard. If empty, one 'Play game_title' button will be shown. If not empty, the first button must launch the game.
     * @return Message|null
     */
    public function sendGame(int $chat_id, string $game_short_name, ?string $business_connection_id = null, ?int $message_thread_id = null, ?bool $disable_notification = null, ?bool $protect_content = null, ?bool $allow_paid_broadcast = null, ?string $message_effect_id = null, ?ReplyParameters $reply_parameters = null, ?InlineKeyboardMarkup $reply_markup = null, ...$args): Message|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('sendGame', $vars), [Message::class]);
    }

    /**
     * Required if chat_id and message_id are not specified. Identifier of the inline message
     * @param int $user_id User identifier
     * @param int $score New score, must be non-negative
     * @param bool|null $force Pass True if the high score is allowed to decrease. This can be useful when fixing mistakes or banning cheaters
     * @param bool|null $disable_edit_message Pass True if the game message should not be automatically edited to include the current scoreboard
     * @param int|null $chat_id Required if inline_message_id is not specified. Unique identifier for the target chat
     * @param int|null $message_id Required if inline_message_id is not specified. Identifier of the sent message
     * @param string|null $inline_message_id Required if chat_id and message_id are not specified. Identifier of the inline message
     * @return Message|true|null
     */
    public function setGameScore(int $user_id, int $score, ?bool $force = null, ?bool $disable_edit_message = null, ?int $chat_id = null, ?int $message_id = null, ?string $inline_message_id = null, ...$args): Message|true|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('setGameScore', $vars), [[Message::class, 'true']]);
    }

    /**
     * Required if chat_id and message_id are not specified. Identifier of the inline message
     * @param int $user_id Target user id
     * @param int|null $chat_id Required if inline_message_id is not specified. Unique identifier for the target chat
     * @param int|null $message_id Required if inline_message_id is not specified. Identifier of the sent message
     * @param string|null $inline_message_id Required if chat_id and message_id are not specified. Identifier of the inline message
     * @return array<GameHighScore>|null
     */
    public function getGameHighScores(int $user_id, ?int $chat_id = null, ?int $message_id = null, ?string $inline_message_id = null, ...$args): array|null
    {
        $vars = get_defined_vars();
        unset($vars['args']);
        $vars += $args;
        return $this->castValue($this->call('getGameHighScores', $vars), ['array', GameHighScore::class]);
    }


}
