<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class ForumTopic
{
    use Concerns\Data;

    public function __construct(
        /** @var int Unique identifier of the forum topic */
        public int $message_thread_id,
        
        /** @var string Name of the topic */
        public string $name,
        
        /** @var int Color of the topic icon in RGB format */
        public int $icon_color,
        
        /** @var string|null Optional. Unique identifier of the custom emoji shown as the topic icon */
        public null|string $icon_custom_emoji_id = null,
        
        
    ) { }
}
