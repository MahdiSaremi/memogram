<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class ReactionTypePaid extends ReactionType
{
    use Concerns\Data;

    /** @var string Type of the reaction, always “paid” */
    public string $type = 'paid';

    public function __construct(
    ) { }
}
