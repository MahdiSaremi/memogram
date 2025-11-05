<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class StoryAreaTypeWeather extends StoryAreaType
{
    use Concerns\Data;

    /** @var string Type of the area, always “weather” */
    public string $type = 'weather';

    public function __construct(
        /** @var float Temperature, in degree Celsius */
        public float $temperature,
        
        /** @var string Emoji representing the weather */
        public string $emoji,
        
        /** @var int A color of the area background in the ARGB format */
        public int $background_color,
        
        
    ) { }
}
