<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class Checklist
{
    use Concerns\Data;

    public function __construct(
        /** @var string Title of the checklist */
        public string $title,
        
        /** @var array<\MemoGram\Api\Types\MessageEntity>|null Optional. Special entities that appear in the checklist title */
        public null|array $title_entities = null,
        
        /** @var array<\MemoGram\Api\Types\ChecklistTask> List of tasks in the checklist */
        public array $tasks,
        
        /** @var bool|null Optional. True, if users other than the creator of the list can add tasks to the list */
        public null|bool $others_can_add_tasks = null,
        
        /** @var bool|null Optional. True, if users other than the creator of the list can mark tasks as done or not done */
        public null|bool $others_can_mark_tasks_as_done = null,
        
        
    ) { }
}
