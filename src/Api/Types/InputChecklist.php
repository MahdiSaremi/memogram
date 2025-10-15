<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class InputChecklist
{
    use Concerns\Data;

    public function __construct(
        /** @var string Title of the checklist; 1-255 characters after entities parsing */
        public string $title,
        
        /** @var string|null Optional. Mode for parsing entities in the title. See formatting options for more details. */
        public null|string $parse_mode = null,
        
        /** @var array<\MemoGram\Api\Types\MessageEntity>|null Optional. List of special entities that appear in the title, which can be specified instead of parse_mode. Currently, only bold, italic, underline, strikethrough, spoiler, and custom_emoji entities are allowed. */
        public null|array $title_entities = null,
        
        /** @var array<\MemoGram\Api\Types\InputChecklistTask> List of 1-30 tasks in the checklist */
        public array $tasks,
        
        /** @var bool|null Optional. Pass True if other users can add tasks to the checklist */
        public null|bool $others_can_add_tasks = null,
        
        /** @var bool|null Optional. Pass True if other users can mark tasks as done or not done in the checklist */
        public null|bool $others_can_mark_tasks_as_done = null,
        
        
    ) { }
}
