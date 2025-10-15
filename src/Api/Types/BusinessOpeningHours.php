<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class BusinessOpeningHours
{
    use Concerns\Data;

    public function __construct(
        /** @var string Unique name of the time zone for which the opening hours are defined */
        public string $time_zone_name,
        
        /** @var array<\MemoGram\Api\Types\BusinessOpeningHoursInterval> List of time intervals describing business opening hours */
        public array $opening_hours,
        
        
    ) { }
}
