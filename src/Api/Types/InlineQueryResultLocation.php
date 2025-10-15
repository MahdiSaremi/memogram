<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\InlineKeyboardMarkup;
use MemoGram\Api\Types\InputMessageContent;


class InlineQueryResultLocation
{
    use Concerns\Data;

    public function __construct(
        /** @var string Type of the result, must be location */
        public string $type,
        
        /** @var string Unique identifier for this result, 1-64 Bytes */
        public string $id,
        
        /** @var float Location latitude in degrees */
        public float $latitude,
        
        /** @var float Location longitude in degrees */
        public float $longitude,
        
        /** @var string Location title */
        public string $title,
        
        /** @var float|null Optional. The radius of uncertainty for the location, measured in meters; 0-1500 */
        public null|float $horizontal_accuracy = null,
        
        /** @var int|null Optional. Period in seconds during which the location can be updated, should be between 60 and 86400, or 0x7FFFFFFF for live locations that can be edited indefinitely. */
        public null|int $live_period = null,
        
        /** @var int|null Optional. For live locations, a direction in which the user is moving, in degrees. Must be between 1 and 360 if specified. */
        public null|int $heading = null,
        
        /** @var int|null Optional. For live locations, a maximum distance for proximity alerts about approaching another chat member, in meters. Must be between 1 and 100000 if specified. */
        public null|int $proximity_alert_radius = null,
        
        /** @var InlineKeyboardMarkup|null Optional. Inline keyboard attached to the message */
        public null|InlineKeyboardMarkup $reply_markup = null,
        
        /** @var InputMessageContent|null Optional. Content of the message to be sent instead of the location */
        public null|InputMessageContent $input_message_content = null,
        
        /** @var string|null Optional. Url of the thumbnail for the result */
        public null|string $thumbnail_url = null,
        
        /** @var int|null Optional. Thumbnail width */
        public null|int $thumbnail_width = null,
        
        /** @var int|null Optional. Thumbnail height */
        public null|int $thumbnail_height = null,
        
        
    ) { }
}
