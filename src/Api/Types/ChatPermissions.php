<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class ChatPermissions
{
    use Concerns\Data;

    public function __construct(
        /** @var bool|null Optional. True, if the user is allowed to send text messages, contacts, giveaways, giveaway winners, invoices, locations and venues */
        public null|bool $can_send_messages = null,
        
        /** @var bool|null Optional. True, if the user is allowed to send audios */
        public null|bool $can_send_audios = null,
        
        /** @var bool|null Optional. True, if the user is allowed to send documents */
        public null|bool $can_send_documents = null,
        
        /** @var bool|null Optional. True, if the user is allowed to send photos */
        public null|bool $can_send_photos = null,
        
        /** @var bool|null Optional. True, if the user is allowed to send videos */
        public null|bool $can_send_videos = null,
        
        /** @var bool|null Optional. True, if the user is allowed to send video notes */
        public null|bool $can_send_video_notes = null,
        
        /** @var bool|null Optional. True, if the user is allowed to send voice notes */
        public null|bool $can_send_voice_notes = null,
        
        /** @var bool|null Optional. True, if the user is allowed to send polls and checklists */
        public null|bool $can_send_polls = null,
        
        /** @var bool|null Optional. True, if the user is allowed to send animations, games, stickers and use inline bots */
        public null|bool $can_send_other_messages = null,
        
        /** @var bool|null Optional. True, if the user is allowed to add web page previews to their messages */
        public null|bool $can_add_web_page_previews = null,
        
        /** @var bool|null Optional. True, if the user is allowed to change the chat title, photo and other settings. Ignored in public supergroups */
        public null|bool $can_change_info = null,
        
        /** @var bool|null Optional. True, if the user is allowed to invite new users to the chat */
        public null|bool $can_invite_users = null,
        
        /** @var bool|null Optional. True, if the user is allowed to pin messages. Ignored in public supergroups */
        public null|bool $can_pin_messages = null,
        
        /** @var bool|null Optional. True, if the user is allowed to create forum topics. If omitted defaults to the value of can_pin_messages */
        public null|bool $can_manage_topics = null,
        
        
    ) { }
}
