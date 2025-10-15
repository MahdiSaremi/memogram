<?php

namespace MemoGram\Tests\Api;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use MemoGram\Api\TelegramApi;
use MemoGram\Api\Types\ReplyParameters;
use MemoGram\Tests\TestCase;

class ApiCallingTest extends TestCase
{
    public function testCallCustomMethod()
    {
        Http::fake();

        $api = new TelegramApi('TOKEN');

        $api->call('test', ['x' => 'y']);

        Http::assertSent(function (Request $request) {
            return $request->url() == 'https://api.telegram.org/botTOKEN/test'
                && $request->data() == ['x' => 'y'];
        });
    }

    public function testSendingMessage()
    {
        Http::fake();

        $api = new TelegramApi('TOKEN');

        $api->sendMessage(
            chat_id: 100,
            text: 'Salam',
        );

        Http::assertSent(function (Request $request) {
            return $request->url() == 'https://api.telegram.org/botTOKEN/sendMessage'
                && $request->data() == ['chat_id' => 100, 'text' => 'Salam'];
        });
    }

    public function testSendingMessageWithAdditionalOptions()
    {
        Http::fake();

        $api = new TelegramApi('TOKEN');

        $api->sendMessage(
            chat_id: 100,
            text: 'Salam',
            reply_parameters: new ReplyParameters(
                message_id: 200,
                allow_sending_without_reply: true,
            ),
        );

        Http::assertSent(function (Request $request) {
            return $request->url() == 'https://api.telegram.org/botTOKEN/sendMessage'
                && $request->data() == ['chat_id' => 100, 'text' => 'Salam', 'reply_parameters' => ['message_id' => 200, 'allow_sending_without_reply' => true]];
        });
    }
}