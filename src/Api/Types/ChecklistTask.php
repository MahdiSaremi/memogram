<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\User;


class ChecklistTask
{
    use Concerns\Data;

    public function __construct(
        /** @var int Unique identifier of the task */
        public int $id,
        
        /** @var string Text of the task */
        public string $text,
        
        /** @var array<\MemoGram\Api\Types\MessageEntity>|null Optional. Special entities that appear in the task text */
        public null|array $text_entities = null,
        
        /** @var User|null Optional. User that completed the task; omitted if the task wasn't completed */
        public null|User $completed_by_user = null,
        
        /** @var int|null Optional. Point in time (Unix timestamp) when the task was completed; 0 if the task wasn't completed */
        public null|int $completion_date = null,
        
        
    ) { }
}
