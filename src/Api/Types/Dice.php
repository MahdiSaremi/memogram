<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class Dice
{
    use Concerns\Data;

    public function __construct(
        /** @var string Emoji on which the dice throw animation is based */
        public string $emoji,
        
        /** @var int Value of the dice, 1-6 for “”, “” and “” base emoji, 1-5 for “” and “” base emoji, 1-64 for “” base emoji */
        public int $value,
        
        
    ) { }
}
