<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\Document;
use MemoGram\Api\Types\BackgroundFill;


class BackgroundTypePattern extends BackgroundType
{
    use Concerns\Data;

    /** @var string Type of the background, always “pattern” */
    public string $type = 'pattern';

    public function __construct(
        /** @var Document Document with the pattern */
        public Document $document,
        
        /** @var BackgroundFill The background fill that is combined with the pattern */
        public BackgroundFill $fill,
        
        /** @var int Intensity of the pattern when it is shown above the filled background; 0-100 */
        public int $intensity,
        
        /** @var bool|null Optional. True, if the background fill must be applied only to the pattern itself. All other pixels are black in this case. For dark themes only */
        public null|bool $is_inverted = null,
        
        /** @var bool|null Optional. True, if the background moves slightly when the device is tilted */
        public null|bool $is_moving = null,
        
        
    ) { }
}
