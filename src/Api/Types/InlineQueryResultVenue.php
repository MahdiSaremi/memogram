<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\InlineKeyboardMarkup;
use MemoGram\Api\Types\InputMessageContent;


class InlineQueryResultVenue
{
    use Concerns\Data;

    public function __construct(
        /** @var string Type of the result, must be venue */
        public string $type,
        
        /** @var string Unique identifier for this result, 1-64 Bytes */
        public string $id,
        
        /** @var float Latitude of the venue location in degrees */
        public float $latitude,
        
        /** @var float Longitude of the venue location in degrees */
        public float $longitude,
        
        /** @var string Title of the venue */
        public string $title,
        
        /** @var string Address of the venue */
        public string $address,
        
        /** @var string|null Optional. Foursquare identifier of the venue if known */
        public null|string $foursquare_id = null,
        
        /** @var string|null Optional. Foursquare type of the venue, if known. (For example, “arts_entertainment/default”, “arts_entertainment/aquarium” or “food/icecream”.) */
        public null|string $foursquare_type = null,
        
        /** @var string|null Optional. Google Places identifier of the venue */
        public null|string $google_place_id = null,
        
        /** @var string|null Optional. Google Places type of the venue. (See supported types.) */
        public null|string $google_place_type = null,
        
        /** @var InlineKeyboardMarkup|null Optional. Inline keyboard attached to the message */
        public null|InlineKeyboardMarkup $reply_markup = null,
        
        /** @var InputMessageContent|null Optional. Content of the message to be sent instead of the venue */
        public null|InputMessageContent $input_message_content = null,
        
        /** @var string|null Optional. Url of the thumbnail for the result */
        public null|string $thumbnail_url = null,
        
        /** @var int|null Optional. Thumbnail width */
        public null|int $thumbnail_width = null,
        
        /** @var int|null Optional. Thumbnail height */
        public null|int $thumbnail_height = null,
        
        
    ) { }
}
