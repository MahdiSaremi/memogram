<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class BusinessOpeningHoursInterval
{
    use Concerns\Data;

    public function __construct(
        /** @var int The minute's sequence number in a week, starting on Monday, marking the start of the time interval during which the business is open; 0 - 7 * 24 * 60 */
        public int $opening_minute,
        
        /** @var int The minute's sequence number in a week, starting on Monday, marking the end of the time interval during which the business is open; 0 - 8 * 24 * 60 */
        public int $closing_minute,
        
        
    ) { }
}
