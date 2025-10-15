<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class WriteAccessAllowed
{
    use Concerns\Data;

    public function __construct(
        /** @var bool|null Optional. True, if the access was granted after the user accepted an explicit request from a Web App sent by the method requestWriteAccess */
        public null|bool $from_request = null,
        
        /** @var string|null Optional. Name of the Web App, if the access was granted when the Web App was launched from a link */
        public null|string $web_app_name = null,
        
        /** @var bool|null Optional. True, if the access was granted when the bot was added to the attachment or side menu */
        public null|bool $from_attachment_menu = null,
        
        
    ) { }
}
