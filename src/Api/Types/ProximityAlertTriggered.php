<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\User;


class ProximityAlertTriggered
{
    use Concerns\Data;

    public function __construct(
        /** @var User User that triggered the alert */
        public User $traveler,
        
        /** @var User User that set the alert */
        public User $watcher,
        
        /** @var int The distance between the users */
        public int $distance,
        
        
    ) { }
}
