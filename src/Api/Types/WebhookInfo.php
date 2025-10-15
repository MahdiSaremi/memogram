<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class WebhookInfo
{
    use Concerns\Data;

    public function __construct(
        /** @var string Webhook URL, may be empty if webhook is not set up */
        public string $url,
        
        /** @var bool True, if a custom certificate was provided for webhook certificate checks */
        public bool $has_custom_certificate,
        
        /** @var int Number of updates awaiting delivery */
        public int $pending_update_count,
        
        /** @var string|null Optional. Currently used webhook IP address */
        public null|string $ip_address = null,
        
        /** @var int|null Optional. Unix time for the most recent error that happened when trying to deliver an update via webhook */
        public null|int $last_error_date = null,
        
        /** @var string|null Optional. Error message in human-readable format for the most recent error that happened when trying to deliver an update via webhook */
        public null|string $last_error_message = null,
        
        /** @var int|null Optional. Unix time of the most recent error that happened when trying to synchronize available updates with Telegram datacenters */
        public null|int $last_synchronization_error_date = null,
        
        /** @var int|null Optional. The maximum allowed number of simultaneous HTTPS connections to the webhook for update delivery */
        public null|int $max_connections = null,
        
        /** @var array<\MemoGram\Api\Types\string>|null Optional. A list of update types the bot is subscribed to. Defaults to all update types except chat_member */
        public null|array $allowed_updates = null,
        
        
    ) { }
}
