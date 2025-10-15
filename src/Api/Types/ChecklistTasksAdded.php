<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\Message;


class ChecklistTasksAdded
{
    use Concerns\Data;

    public function __construct(
        /** @var Message|null Optional. Message containing the checklist to which the tasks were added. Note that the Message object in this field will not contain the reply_to_message field even if it itself is a reply. */
        public null|Message $checklist_message = null,
        
        /** @var array<\MemoGram\Api\Types\ChecklistTask> List of tasks added to the checklist */
        public array $tasks,
        
        
    ) { }
}
