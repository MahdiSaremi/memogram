<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class Birthdate
{
    use Concerns\Data;

    public function __construct(
        /** @var int Day of the user's birth; 1-31 */
        public int $day,
        
        /** @var int Month of the user's birth; 1-12 */
        public int $month,
        
        /** @var int|null Optional. Year of the user's birth */
        public null|int $year = null,
        
        
    ) { }
}
