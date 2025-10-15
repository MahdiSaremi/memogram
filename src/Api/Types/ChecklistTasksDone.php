<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\Message;


class ChecklistTasksDone
{
    use Concerns\Data;

    public function __construct(
        /** @var Message|null Optional. Message containing the checklist whose tasks were marked as done or not done. Note that the Message object in this field will not contain the reply_to_message field even if it itself is a reply. */
        public null|Message $checklist_message = null,
        
        /** @var array<\MemoGram\Api\Types\int>|null Optional. Identifiers of the tasks that were marked as done */
        public null|array $marked_as_done_task_ids = null,
        
        /** @var array<\MemoGram\Api\Types\int>|null Optional. Identifiers of the tasks that were marked as not done */
        public null|array $marked_as_not_done_task_ids = null,
        
        
    ) { }
}
