<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\MessageOrigin;
use MemoGram\Api\Types\Chat;
use MemoGram\Api\Types\LinkPreviewOptions;
use MemoGram\Api\Types\Animation;
use MemoGram\Api\Types\Audio;
use MemoGram\Api\Types\Document;
use MemoGram\Api\Types\PaidMediaInfo;
use MemoGram\Api\Types\Sticker;
use MemoGram\Api\Types\Story;
use MemoGram\Api\Types\Video;
use MemoGram\Api\Types\VideoNote;
use MemoGram\Api\Types\Voice;
use MemoGram\Api\Types\Checklist;
use MemoGram\Api\Types\Contact;
use MemoGram\Api\Types\Dice;
use MemoGram\Api\Types\Game;
use MemoGram\Api\Types\Giveaway;
use MemoGram\Api\Types\GiveawayWinners;
use MemoGram\Api\Types\Invoice;
use MemoGram\Api\Types\Location;
use MemoGram\Api\Types\Poll;
use MemoGram\Api\Types\Venue;


class ExternalReplyInfo
{
    use Concerns\Data;

    public function __construct(
        /** @var MessageOrigin Origin of the message replied to by the given message */
        public MessageOrigin $origin,
        
        /** @var Chat|null Optional. Chat the original message belongs to. Available only if the chat is a supergroup or a channel. */
        public null|Chat $chat = null,
        
        /** @var int|null Optional. Unique message identifier inside the original chat. Available only if the original chat is a supergroup or a channel. */
        public null|int $message_id = null,
        
        /** @var LinkPreviewOptions|null Optional. Options used for link preview generation for the original message, if it is a text message */
        public null|LinkPreviewOptions $link_preview_options = null,
        
        /** @var Animation|null Optional. Message is an animation, information about the animation */
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
        
        /** @var Giveaway|null Optional. Message is a scheduled giveaway, information about the giveaway */
        public null|Giveaway $giveaway = null,
        
        /** @var GiveawayWinners|null Optional. A giveaway with public winners was completed */
        public null|GiveawayWinners $giveaway_winners = null,
        
        /** @var Invoice|null Optional. Message is an invoice for a payment, information about the invoice. More about payments » */
        public null|Invoice $invoice = null,
        
        /** @var Location|null Optional. Message is a shared location, information about the location */
        public null|Location $location = null,
        
        /** @var Poll|null Optional. Message is a native poll, information about the poll */
        public null|Poll $poll = null,
        
        /** @var Venue|null Optional. Message is a venue, information about the venue */
        public null|Venue $venue = null,
        
        
    ) { }
}
