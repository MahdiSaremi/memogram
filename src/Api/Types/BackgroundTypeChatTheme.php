<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class BackgroundTypeChatTheme
{
    use Concerns\Data;

    public function __construct(
        /** @var string Type of the background, always “chat_theme” */
        public string $type,
        
        /** @var string Name of the chat theme, which is usually an emoji */
        public string $theme_name,
        
        
    ) { }
}
