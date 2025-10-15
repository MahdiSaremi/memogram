<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class CopyTextButton
{
    use Concerns\Data;

    public function __construct(
        /** @var string The text to be copied to the clipboard; 1-256 characters */
        public string $text,
        
        
    ) { }
}
