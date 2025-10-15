<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\User;


class GameHighScore
{
    use Concerns\Data;

    public function __construct(
        /** @var int Position in high score table for the game */
        public int $position,
        
        /** @var User User */
        public User $user,
        
        /** @var int Score */
        public int $score,
        
        
    ) { }
}
