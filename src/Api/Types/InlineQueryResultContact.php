<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\InlineKeyboardMarkup;
use MemoGram\Api\Types\InputMessageContent;


class InlineQueryResultContact
{
    use Concerns\Data;

    public function __construct(
        /** @var string Type of the result, must be contact */
        public string $type,
        
        /** @var string Unique identifier for this result, 1-64 Bytes */
        public string $id,
        
        /** @var string Contact's phone number */
        public string $phone_number,
        
        /** @var string Contact's first name */
        public string $first_name,
        
        /** @var string|null Optional. Contact's last name */
        public null|string $last_name = null,
        
        /** @var string|null Optional. Additional data about the contact in the form of a vCard, 0-2048 bytes */
        public null|string $vcard = null,
        
        /** @var InlineKeyboardMarkup|null Optional. Inline keyboard attached to the message */
        public null|InlineKeyboardMarkup $reply_markup = null,
        
        /** @var InputMessageContent|null Optional. Content of the message to be sent instead of the contact */
        public null|InputMessageContent $input_message_content = null,
        
        /** @var string|null Optional. Url of the thumbnail for the result */
        public null|string $thumbnail_url = null,
        
        /** @var int|null Optional. Thumbnail width */
        public null|int $thumbnail_width = null,
        
        /** @var int|null Optional. Thumbnail height */
        public null|int $thumbnail_height = null,
        
        
    ) { }
}
