<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class KeyboardButtonPollType
{
    use Concerns\Data;

    public function __construct(
        /** @var string|null Optional. If quiz is passed, the user will be allowed to create only polls in the quiz mode. If regular is passed, only regular polls will be allowed. Otherwise, the user will be allowed to create a poll of any type. */
        public null|string $type = null,
        
        
    ) { }
}
