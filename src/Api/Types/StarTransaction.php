<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\TransactionPartner;


class StarTransaction
{
    use Concerns\Data;

    public function __construct(
        /** @var string Unique identifier of the transaction. Coincides with the identifier of the original transaction for refund transactions. Coincides with SuccessfulPayment.telegram_payment_charge_id for successful incoming payments from users. */
        public string $id,
        
        /** @var int Integer amount of Telegram Stars transferred by the transaction */
        public int $amount,
        
        /** @var int|null Optional. The number of 1/1000000000 shares of Telegram Stars transferred by the transaction; from 0 to 999999999 */
        public null|int $nanostar_amount = null,
        
        /** @var int Date the transaction was created in Unix time */
        public int $date,
        
        /** @var TransactionPartner|null Optional. Source of an incoming transaction (e.g., a user purchasing goods or services, Fragment refunding a failed withdrawal). Only for incoming transactions */
        public null|TransactionPartner $source = null,
        
        /** @var TransactionPartner|null Optional. Receiver of an outgoing transaction (e.g., a user for a purchase refund, Fragment for a withdrawal). Only for outgoing transactions */
        public null|TransactionPartner $receiver = null,
        
        
    ) { }
}
