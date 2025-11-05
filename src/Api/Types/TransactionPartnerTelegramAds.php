<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class TransactionPartnerTelegramAds
{
    use Concerns\Data;

    /** @var string Type of the transaction partner, always “telegram_ads” */
    public string $type = 'telegram_ads';

    public function __construct(

    ) { }
}
