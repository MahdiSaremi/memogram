<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class ForumTopicEdited
{
    use Concerns\Data;

    public function __construct(
        /** @var string|null Optional. New name of the topic, if it was edited */
        public null|string $name = null,
        
        /** @var string|null Optional. New identifier of the custom emoji shown as the topic icon, if it was edited; an empty string if the icon was removed */
        public null|string $icon_custom_emoji_id = null,
        
        
    ) { }
}
