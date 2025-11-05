<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;


abstract class TransactionPartner
{
    public static function makeDynamic(array $data): self
    {
        return match ($data['type']) {
            'user' => TransactionPartnerUser::makeFromArray($data),
            'chat' => TransactionPartnerChat::makeFromArray($data),
            'affiliate_program' => TransactionPartnerAffiliateProgram::makeFromArray($data),
            'fragment' => TransactionPartnerFragment::makeFromArray($data),
            'telegram_ads' => TransactionPartnerTelegramAds::makeFromArray($data),
            'telegram_api' => TransactionPartnerTelegramApi::makeFromArray($data),
            'other' => TransactionPartnerOther::makeFromArray($data),
        };
    }
}
