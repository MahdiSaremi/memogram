<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\DirectMessagesTopic;
use MemoGram\Api\Types\User;
use MemoGram\Api\Types\Chat;
use MemoGram\Api\Types\MessageOrigin;
use MemoGram\Api\Types\ExternalReplyInfo;
use MemoGram\Api\Types\TextQuote;
use MemoGram\Api\Types\Story;
use MemoGram\Api\Types\LinkPreviewOptions;
use MemoGram\Api\Types\SuggestedPostInfo;
use MemoGram\Api\Types\Animation;
use MemoGram\Api\Types\Audio;
use MemoGram\Api\Types\Document;
use MemoGram\Api\Types\PaidMediaInfo;
use MemoGram\Api\Types\Sticker;
use MemoGram\Api\Types\Video;
use MemoGram\Api\Types\VideoNote;
use MemoGram\Api\Types\Voice;
use MemoGram\Api\Types\Checklist;
use MemoGram\Api\Types\Contact;
use MemoGram\Api\Types\Dice;
use MemoGram\Api\Types\Game;
use MemoGram\Api\Types\Poll;
use MemoGram\Api\Types\Venue;
use MemoGram\Api\Types\Location;
use MemoGram\Api\Types\MessageAutoDeleteTimerChanged;
use MemoGram\Api\Types\Invoice;
use MemoGram\Api\Types\SuccessfulPayment;
use MemoGram\Api\Types\RefundedPayment;
use MemoGram\Api\Types\UsersShared;
use MemoGram\Api\Types\ChatShared;
use MemoGram\Api\Types\GiftInfo;
use MemoGram\Api\Types\UniqueGiftInfo;
use MemoGram\Api\Types\WriteAccessAllowed;
use MemoGram\Api\Types\PassportData;
use MemoGram\Api\Types\ProximityAlertTriggered;
use MemoGram\Api\Types\ChatBoostAdded;
use MemoGram\Api\Types\ChatBackground;
use MemoGram\Api\Types\ChecklistTasksDone;
use MemoGram\Api\Types\ChecklistTasksAdded;
use MemoGram\Api\Types\DirectMessagePriceChanged;
use MemoGram\Api\Types\ForumTopicCreated;
use MemoGram\Api\Types\ForumTopicEdited;
use MemoGram\Api\Types\ForumTopicClosed;
use MemoGram\Api\Types\ForumTopicReopened;
use MemoGram\Api\Types\GeneralForumTopicHidden;
use MemoGram\Api\Types\GeneralForumTopicUnhidden;
use MemoGram\Api\Types\GiveawayCreated;
use MemoGram\Api\Types\Giveaway;
use MemoGram\Api\Types\GiveawayWinners;
use MemoGram\Api\Types\GiveawayCompleted;
use MemoGram\Api\Types\PaidMessagePriceChanged;
use MemoGram\Api\Types\SuggestedPostApproved;
use MemoGram\Api\Types\SuggestedPostApprovalFailed;
use MemoGram\Api\Types\SuggestedPostDeclined;
use MemoGram\Api\Types\SuggestedPostPaid;
use MemoGram\Api\Types\SuggestedPostRefunded;
use MemoGram\Api\Types\VideoChatScheduled;
use MemoGram\Api\Types\VideoChatStarted;
use MemoGram\Api\Types\VideoChatEnded;
use MemoGram\Api\Types\VideoChatParticipantsInvited;
use MemoGram\Api\Types\WebAppData;
use MemoGram\Api\Types\InlineKeyboardMarkup;


class Message implements Event
{
    use Concerns\Data;

    public function __construct(
        /** @var int Unique message identifier inside this chat. In specific instances (e.g., message containing a video sent to a big chat), the server might automatically schedule a message instead of sending it immediately. In such cases, this field will be 0 and the relevant message will be unusable until it is actually sent */
        public int $message_id,
        
        /** @var int|null Optional. Unique identifier of a message thread to which the message belongs; for supergroups only */
        public null|int $message_thread_id = null,
        
        /** @var DirectMessagesTopic|null Optional. Information about the direct messages chat topic that contains the message */
        public null|DirectMessagesTopic $direct_messages_topic = null,
        
        /** @var User|null Optional. Sender of the message; may be empty for messages sent to channels. For backward compatibility, if the message was sent on behalf of a chat, the field contains a fake sender user in non-channel chats */
        public null|User $from = null,
        
        /** @var Chat|null Optional. Sender of the message when sent on behalf of a chat. For example, the supergroup itself for messages sent by its anonymous administrators or a linked channel for messages automatically forwarded to the channel's discussion group. For backward compatibility, if the message was sent on behalf of a chat, the field from contains a fake sender user in non-channel chats. */
        public null|Chat $sender_chat = null,
        
        /** @var int|null Optional. If the sender of the message boosted the chat, the number of boosts added by the user */
        public null|int $sender_boost_count = null,
        
        /** @var User|null Optional. The bot that actually sent the message on behalf of the business account. Available only for outgoing messages sent on behalf of the connected business account. */
        public null|User $sender_business_bot = null,
        
        /** @var int Date the message was sent in Unix time. It is always a positive number, representing a valid date. */
        public int $date,
        
        /** @var string|null Optional. Unique identifier of the business connection from which the message was received. If non-empty, the message belongs to a chat of the corresponding business account that is independent from any potential bot chat which might share the same identifier. */
        public null|string $business_connection_id = null,
        
        /** @var Chat Chat the message belongs to */
        public Chat $chat,
        
        /** @var MessageOrigin|null Optional. Information about the original message for forwarded messages */
        public null|MessageOrigin $forward_origin = null,
        
        /** @var bool|null Optional. True, if the message is sent to a forum topic */
        public null|bool $is_topic_message = null,
        
        /** @var bool|null Optional. True, if the message is a channel post that was automatically forwarded to the connected discussion group */
        public null|bool $is_automatic_forward = null,
        
        /** @var Message|null Optional. For replies in the same chat and message thread, the original message. Note that the Message object in this field will not contain further reply_to_message fields even if it itself is a reply. */
        public null|Message $reply_to_message = null,
        
        /** @var ExternalReplyInfo|null Optional. Information about the message that is being replied to, which may come from another chat or forum topic */
        public null|ExternalReplyInfo $external_reply = null,
        
        /** @var TextQuote|null Optional. For replies that quote part of the original message, the quoted part of the message */
        public null|TextQuote $quote = null,
        
        /** @var Story|null Optional. For replies to a story, the original story */
        public null|Story $reply_to_story = null,
        
        /** @var int|null Optional. Identifier of the specific checklist task that is being replied to */
        public null|int $reply_to_checklist_task_id = null,
        
        /** @var User|null Optional. Bot through which the message was sent */
        public null|User $via_bot = null,
        
        /** @var int|null Optional. Date the message was last edited in Unix time */
        public null|int $edit_date = null,
        
        /** @var bool|null Optional. True, if the message can't be forwarded */
        public null|bool $has_protected_content = null,
        
        /** @var bool|null Optional. True, if the message was sent by an implicit action, for example, as an away or a greeting business message, or as a scheduled message */
        public null|bool $is_from_offline = null,
        
        /** @var bool|null Optional. True, if the message is a paid post. Note that such posts must not be deleted for 24 hours to receive the payment and can't be edited. */
        public null|bool $is_paid_post = null,
        
        /** @var string|null Optional. The unique identifier of a media message group this message belongs to */
        public null|string $media_group_id = null,
        
        /** @var string|null Optional. Signature of the post author for messages in channels, or the custom title of an anonymous group administrator */
        public null|string $author_signature = null,
        
        /** @var int|null Optional. The number of Telegram Stars that were paid by the sender of the message to send it */
        public null|int $paid_star_count = null,
        
        /** @var string|null Optional. For text messages, the actual UTF-8 text of the message */
        public null|string $text = null,
        
        /** @var array<\MemoGram\Api\Types\MessageEntity>|null Optional. For text messages, special entities like usernames, URLs, bot commands, etc. that appear in the text */
        public null|array $entities = null,
        
        /** @var LinkPreviewOptions|null Optional. Options used for link preview generation for the message, if it is a text message and link preview options were changed */
        public null|LinkPreviewOptions $link_preview_options = null,
        
        /** @var SuggestedPostInfo|null Optional. Information about suggested post parameters if the message is a suggested post in a channel direct messages chat. If the message is an approved or declined suggested post, then it can't be edited. */
        public null|SuggestedPostInfo $suggested_post_info = null,
        
        /** @var string|null Optional. Unique identifier of the message effect added to the message */
        public null|string $effect_id = null,
        
        /** @var Animation|null Optional. Message is an animation, information about the animation. For backward compatibility, when this field is set, the document field will also be set */
        public null|Animation $animation = null,
        
        /** @var Audio|null Optional. Message is an audio file, information about the file */
        public null|Audio $audio = null,
        
        /** @var Document|null Optional. Message is a general file, information about the file */
        public null|Document $document = null,
        
        /** @var PaidMediaInfo|null Optional. Message contains paid media; information about the paid media */
        public null|PaidMediaInfo $paid_media = null,
        
        /** @var array<\MemoGram\Api\Types\PhotoSize>|null Optional. Message is a photo, available sizes of the photo */
        public null|array $photo = null,
        
        /** @var Sticker|null Optional. Message is a sticker, information about the sticker */
        public null|Sticker $sticker = null,
        
        /** @var Story|null Optional. Message is a forwarded story */
        public null|Story $story = null,
        
        /** @var Video|null Optional. Message is a video, information about the video */
        public null|Video $video = null,
        
        /** @var VideoNote|null Optional. Message is a video note, information about the video message */
        public null|VideoNote $video_note = null,
        
        /** @var Voice|null Optional. Message is a voice message, information about the file */
        public null|Voice $voice = null,
        
        /** @var string|null Optional. Caption for the animation, audio, document, paid media, photo, video or voice */
        public null|string $caption = null,
        
        /** @var array<\MemoGram\Api\Types\MessageEntity>|null Optional. For messages with a caption, special entities like usernames, URLs, bot commands, etc. that appear in the caption */
        public null|array $caption_entities = null,
        
        /** @var bool|null Optional. True, if the caption must be shown above the message media */
        public null|bool $show_caption_above_media = null,
        
        /** @var bool|null Optional. True, if the message media is covered by a spoiler animation */
        public null|bool $has_media_spoiler = null,
        
        /** @var Checklist|null Optional. Message is a checklist */
        public null|Checklist $checklist = null,
        
        /** @var Contact|null Optional. Message is a shared contact, information about the contact */
        public null|Contact $contact = null,
        
        /** @var Dice|null Optional. Message is a dice with random value */
        public null|Dice $dice = null,
        
        /** @var Game|null Optional. Message is a game, information about the game. More about games » */
        public null|Game $game = null,
        
        /** @var Poll|null Optional. Message is a native poll, information about the poll */
        public null|Poll $poll = null,
        
        /** @var Venue|null Optional. Message is a venue, information about the venue. For backward compatibility, when this field is set, the location field will also be set */
        public null|Venue $venue = null,
        
        /** @var Location|null Optional. Message is a shared location, information about the location */
        public null|Location $location = null,
        
        /** @var array<\MemoGram\Api\Types\User>|null Optional. New members that were added to the group or supergroup and information about them (the bot itself may be one of these members) */
        public null|array $new_chat_members = null,
        
        /** @var User|null Optional. A member was removed from the group, information about them (this member may be the bot itself) */
        public null|User $left_chat_member = null,
        
        /** @var string|null Optional. A chat title was changed to this value */
        public null|string $new_chat_title = null,
        
        /** @var array<\MemoGram\Api\Types\PhotoSize>|null Optional. A chat photo was change to this value */
        public null|array $new_chat_photo = null,
        
        /** @var bool|null Optional. Service message: the chat photo was deleted */
        public null|bool $delete_chat_photo = null,
        
        /** @var bool|null Optional. Service message: the group has been created */
        public null|bool $group_chat_created = null,
        
        /** @var bool|null Optional. Service message: the supergroup has been created. This field can't be received in a message coming through updates, because bot can't be a member of a supergroup when it is created. It can only be found in reply_to_message if someone replies to a very first message in a directly created supergroup. */
        public null|bool $supergroup_chat_created = null,
        
        /** @var bool|null Optional. Service message: the channel has been created. This field can't be received in a message coming through updates, because bot can't be a member of a channel when it is created. It can only be found in reply_to_message if someone replies to a very first message in a channel. */
        public null|bool $channel_chat_created = null,
        
        /** @var MessageAutoDeleteTimerChanged|null Optional. Service message: auto-delete timer settings changed in the chat */
        public null|MessageAutoDeleteTimerChanged $message_auto_delete_timer_changed = null,
        
        /** @var int|null Optional. The group has been migrated to a supergroup with the specified identifier. This number may have more than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it. But it has at most 52 significant bits, so a signed 64-bit integer or double-precision float type are safe for storing this identifier. */
        public null|int $migrate_to_chat_id = null,
        
        /** @var int|null Optional. The supergroup has been migrated from a group with the specified identifier. This number may have more than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it. But it has at most 52 significant bits, so a signed 64-bit integer or double-precision float type are safe for storing this identifier. */
        public null|int $migrate_from_chat_id = null,
        
        /** @var InaccessibleMessage|Message|null Optional. Specified message was pinned. Note that the Message object in this field will not contain further reply_to_message fields even if it itself is a reply. */
        #[\MemoGram\Api\Attributes\_Choose("date", [[0, InaccessibleMessage::class], [null, Message::class]])]
        public null|InaccessibleMessage|Message $pinned_message = null,
        
        /** @var Invoice|null Optional. Message is an invoice for a payment, information about the invoice. More about payments » */
        public null|Invoice $invoice = null,
        
        /** @var SuccessfulPayment|null Optional. Message is a service message about a successful payment, information about the payment. More about payments » */
        public null|SuccessfulPayment $successful_payment = null,
        
        /** @var RefundedPayment|null Optional. Message is a service message about a refunded payment, information about the payment. More about payments » */
        public null|RefundedPayment $refunded_payment = null,
        
        /** @var UsersShared|null Optional. Service message: users were shared with the bot */
        public null|UsersShared $users_shared = null,
        
        /** @var ChatShared|null Optional. Service message: a chat was shared with the bot */
        public null|ChatShared $chat_shared = null,
        
        /** @var GiftInfo|null Optional. Service message: a regular gift was sent or received */
        public null|GiftInfo $gift = null,
        
        /** @var UniqueGiftInfo|null Optional. Service message: a unique gift was sent or received */
        public null|UniqueGiftInfo $unique_gift = null,
        
        /** @var string|null Optional. The domain name of the website on which the user has logged in. More about Telegram Login » */
        public null|string $connected_website = null,
        
        /** @var WriteAccessAllowed|null Optional. Service message: the user allowed the bot to write messages after adding it to the attachment or side menu, launching a Web App from a link, or accepting an explicit request from a Web App sent by the method requestWriteAccess */
        public null|WriteAccessAllowed $write_access_allowed = null,
        
        /** @var PassportData|null Optional. Telegram Passport data */
        public null|PassportData $passport_data = null,
        
        /** @var ProximityAlertTriggered|null Optional. Service message. A user in the chat triggered another user's proximity alert while sharing Live Location. */
        public null|ProximityAlertTriggered $proximity_alert_triggered = null,
        
        /** @var ChatBoostAdded|null Optional. Service message: user boosted the chat */
        public null|ChatBoostAdded $boost_added = null,
        
        /** @var ChatBackground|null Optional. Service message: chat background set */
        public null|ChatBackground $chat_background_set = null,
        
        /** @var ChecklistTasksDone|null Optional. Service message: some tasks in a checklist were marked as done or not done */
        public null|ChecklistTasksDone $checklist_tasks_done = null,
        
        /** @var ChecklistTasksAdded|null Optional. Service message: tasks were added to a checklist */
        public null|ChecklistTasksAdded $checklist_tasks_added = null,
        
        /** @var DirectMessagePriceChanged|null Optional. Service message: the price for paid messages in the corresponding direct messages chat of a channel has changed */
        public null|DirectMessagePriceChanged $direct_message_price_changed = null,
        
        /** @var ForumTopicCreated|null Optional. Service message: forum topic created */
        public null|ForumTopicCreated $forum_topic_created = null,
        
        /** @var ForumTopicEdited|null Optional. Service message: forum topic edited */
        public null|ForumTopicEdited $forum_topic_edited = null,
        
        /** @var ForumTopicClosed|null Optional. Service message: forum topic closed */
        public null|ForumTopicClosed $forum_topic_closed = null,
        
        /** @var ForumTopicReopened|null Optional. Service message: forum topic reopened */
        public null|ForumTopicReopened $forum_topic_reopened = null,
        
        /** @var GeneralForumTopicHidden|null Optional. Service message: the 'General' forum topic hidden */
        public null|GeneralForumTopicHidden $general_forum_topic_hidden = null,
        
        /** @var GeneralForumTopicUnhidden|null Optional. Service message: the 'General' forum topic unhidden */
        public null|GeneralForumTopicUnhidden $general_forum_topic_unhidden = null,
        
        /** @var GiveawayCreated|null Optional. Service message: a scheduled giveaway was created */
        public null|GiveawayCreated $giveaway_created = null,
        
        /** @var Giveaway|null Optional. The message is a scheduled giveaway message */
        public null|Giveaway $giveaway = null,
        
        /** @var GiveawayWinners|null Optional. A giveaway with public winners was completed */
        public null|GiveawayWinners $giveaway_winners = null,
        
        /** @var GiveawayCompleted|null Optional. Service message: a giveaway without public winners was completed */
        public null|GiveawayCompleted $giveaway_completed = null,
        
        /** @var PaidMessagePriceChanged|null Optional. Service message: the price for paid messages has changed in the chat */
        public null|PaidMessagePriceChanged $paid_message_price_changed = null,
        
        /** @var SuggestedPostApproved|null Optional. Service message: a suggested post was approved */
        public null|SuggestedPostApproved $suggested_post_approved = null,
        
        /** @var SuggestedPostApprovalFailed|null Optional. Service message: approval of a suggested post has failed */
        public null|SuggestedPostApprovalFailed $suggested_post_approval_failed = null,
        
        /** @var SuggestedPostDeclined|null Optional. Service message: a suggested post was declined */
        public null|SuggestedPostDeclined $suggested_post_declined = null,
        
        /** @var SuggestedPostPaid|null Optional. Service message: payment for a suggested post was received */
        public null|SuggestedPostPaid $suggested_post_paid = null,
        
        /** @var SuggestedPostRefunded|null Optional. Service message: payment for a suggested post was refunded */
        public null|SuggestedPostRefunded $suggested_post_refunded = null,
        
        /** @var VideoChatScheduled|null Optional. Service message: video chat scheduled */
        public null|VideoChatScheduled $video_chat_scheduled = null,
        
        /** @var VideoChatStarted|null Optional. Service message: video chat started */
        public null|VideoChatStarted $video_chat_started = null,
        
        /** @var VideoChatEnded|null Optional. Service message: video chat ended */
        public null|VideoChatEnded $video_chat_ended = null,
        
        /** @var VideoChatParticipantsInvited|null Optional. Service message: new participants invited to a video chat */
        public null|VideoChatParticipantsInvited $video_chat_participants_invited = null,
        
        /** @var WebAppData|null Optional. Service message: data sent by a Web App */
        public null|WebAppData $web_app_data = null,
        
        /** @var InlineKeyboardMarkup|null Optional. Inline keyboard attached to the message. login_url buttons are represented as ordinary url buttons. */
        public null|InlineKeyboardMarkup $reply_markup = null,
        
        
    ) { }

    public const TYPE_PHOTO = 'photo';
    public const TYPE_CONTACT = 'contact';
    public const TYPE_LOCATION = 'location';
    public const TYPE_VIDEO = 'video';
    public const TYPE_VOICE = 'voice';
    public const TYPE_AUDIO = 'audio';
    public const TYPE_STICKER = 'sticker';
    public const TYPE_ANIMATION = 'animation';
    public const TYPE_STORY = 'story';
    public const TYPE_VIDEO_NOTE = 'video_note';
    public const TYPE_DICE = 'dice';
    public const TYPE_GAME = 'game';
    public const TYPE_DOCUMENT = 'document';
    public const TYPE_POLL = 'poll';
    public const TYPE_VENUE = 'venue';
    public const TYPE_NEW_CHAT_MEMBERS = 'new_chat_members';
    public const TYPE_LEFT_CHAT_MEMBER = 'left_chat_member';
    public const TYPE_NEW_CHAT_TITLE = 'new_chat_title';
    public const TYPE_DELETE_CHAT_PHOTO = 'delete_chat_photo';
    public const TYPE_GROUP_CHAT_CREATED = 'group_chat_created';
    public const TYPE_SUPERGROUP_CHAT_CREATED = 'supergroup_chat_created';
    public const TYPE_CHANNEL_CHAT_CREATED = 'channel_chat_created';
    public const TYPE_USERS_SHARED = 'users_shared';
    public const TYPE_CHAT_SHARED = 'chat_shared';
    public const TYPE_MEDIA = 'media';
    public const TYPE_TEXT = 'text';
    public const TYPE_UNKNOWN = 'unknown';

    public function getType(): string
    {
        return match (true) {
            null !== $this->photo => self::TYPE_PHOTO,
            null !== $this->contact => self::TYPE_CONTACT,
            null !== $this->location => self::TYPE_LOCATION,
            null !== $this->video => self::TYPE_VIDEO,
            null !== $this->voice => self::TYPE_VOICE,
            null !== $this->audio => self::TYPE_AUDIO,
            null !== $this->sticker => self::TYPE_STICKER,
            null !== $this->animation => self::TYPE_ANIMATION,
            null !== $this->story => self::TYPE_STORY,
            null !== $this->video_note => self::TYPE_VIDEO_NOTE,
            null !== $this->dice => self::TYPE_DICE,
            null !== $this->game => self::TYPE_GAME,
            null !== $this->document => self::TYPE_DOCUMENT,
            null !== $this->poll => self::TYPE_POLL,
            null !== $this->venue => self::TYPE_VENUE,
            null !== $this->new_chat_members => self::TYPE_NEW_CHAT_MEMBERS,
            null !== $this->left_chat_member => self::TYPE_LEFT_CHAT_MEMBER,
            null !== $this->new_chat_title => self::TYPE_NEW_CHAT_TITLE,
            null !== $this->delete_chat_photo => self::TYPE_DELETE_CHAT_PHOTO,
            null !== $this->group_chat_created => self::TYPE_GROUP_CHAT_CREATED,
            null !== $this->supergroup_chat_created => self::TYPE_SUPERGROUP_CHAT_CREATED,
            null !== $this->channel_chat_created => self::TYPE_CHANNEL_CHAT_CREATED,
//            null !== $this->invoice => 'invoice',
            null !== $this->users_shared => self::TYPE_USERS_SHARED,
            null !== $this->chat_shared => self::TYPE_CHAT_SHARED,

            null !== $this->caption => self::TYPE_MEDIA,
            null !== $this->text => self::TYPE_TEXT,

            default => self::TYPE_UNKNOWN,
        };
    }
}
