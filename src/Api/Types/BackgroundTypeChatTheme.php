<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class BackgroundTypeChatTheme extends BackgroundType
{
    use Concerns\Data;

    /** @var string Type of the background, always “chat_theme” */
    public string $type = 'chat_theme';

    public function __construct(
        /** @var string Name of the chat theme, which is usually an emoji */
        public string $theme_name,
        
        
    ) { }
}
