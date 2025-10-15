<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class ForumTopicCreated
{
    use Concerns\Data;

    public function __construct(
        /** @var string Name of the topic */
        public string $name,
        
        /** @var int Color of the topic icon in RGB format */
        public int $icon_color,
        
        /** @var string|null Optional. Unique identifier of the custom emoji shown as the topic icon */
        public null|string $icon_custom_emoji_id = null,
        
        
    ) { }
}
