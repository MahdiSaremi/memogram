<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class WebAppInfo
{
    use Concerns\Data;

    public function __construct(
        /** @var string An HTTPS URL of a Web App to be opened with additional data as specified in Initializing Web Apps */
        public string $url,
        
        
    ) { }
}
