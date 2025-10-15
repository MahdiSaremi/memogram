<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\KeyboardButtonRequestUsers;
use MemoGram\Api\Types\KeyboardButtonRequestChat;
use MemoGram\Api\Types\KeyboardButtonPollType;
use MemoGram\Api\Types\WebAppInfo;


class KeyboardButton
{
    use Concerns\Data;

    public function __construct(
        /** @var string Text of the button. If none of the optional fields are used, it will be sent as a message when the button is pressed */
        public string $text,
        
        /** @var KeyboardButtonRequestUsers|null Optional. If specified, pressing the button will open a list of suitable users. Identifiers of selected users will be sent to the bot in a “users_shared” service message. Available in private chats only. */
        public null|KeyboardButtonRequestUsers $request_users = null,
        
        /** @var KeyboardButtonRequestChat|null Optional. If specified, pressing the button will open a list of suitable chats. Tapping on a chat will send its identifier to the bot in a “chat_shared” service message. Available in private chats only. */
        public null|KeyboardButtonRequestChat $request_chat = null,
        
        /** @var bool|null Optional. If True, the user's phone number will be sent as a contact when the button is pressed. Available in private chats only. */
        public null|bool $request_contact = null,
        
        /** @var bool|null Optional. If True, the user's current location will be sent when the button is pressed. Available in private chats only. */
        public null|bool $request_location = null,
        
        /** @var KeyboardButtonPollType|null Optional. If specified, the user will be asked to create a poll and send it to the bot when the button is pressed. Available in private chats only. */
        public null|KeyboardButtonPollType $request_poll = null,
        
        /** @var WebAppInfo|null Optional. If specified, the described Web App will be launched when the button is pressed. The Web App will be able to send a “web_app_data” service message. Available in private chats only. */
        public null|WebAppInfo $web_app = null,
        
        
    ) { }
}
