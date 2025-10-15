<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class PollOption
{
    use Concerns\Data;

    public function __construct(
        /** @var string Option text, 1-100 characters */
        public string $text,
        
        /** @var array<\MemoGram\Api\Types\MessageEntity>|null Optional. Special entities that appear in the option text. Currently, only custom emoji entities are allowed in poll option texts */
        public null|array $text_entities = null,
        
        /** @var int Number of users that voted for this option */
        public int $voter_count,
        
        
    ) { }
}
