<?php

namespace MemoGram\Tests\Api;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use MemoGram\Api\TelegramApi;
use MemoGram\Api\Types\CallbackQuery;
use MemoGram\Api\Types\Chat;
use MemoGram\Api\Types\InaccessibleMessage;
use MemoGram\Api\Types\Message;
use MemoGram\Tests\TestCase;

class CreatingDataTest extends TestCase
{
    public function testCreatingMessage()
    {
        $message = Message::makeFromArray([
            'message_id' => 100,
            'chat' => [
                'type' => 'private',
                'id' => 200,
            ],
            'date' => 12345,
        ]);

        $this->assertInstanceOf(Message::class, $message);
        $this->assertSame(100, $message->message_id);
        $this->assertInstanceOf(Chat::class, $message->chat);
        $this->assertSame(200, $message->chat->id);
    }

    public function testCreatingWithChooseAttribute()
    {
        $callbackQuery = CallbackQuery::makeFromArray([
            'id' => 'foo',
            'from' => [
                'id' => 100,
                'is_bot' => false,
                'first_name' => 'Mahdi',
            ],
            'chat_instance' => 'something',
            'message' => [
                'message_id' => 400,
                'chat' => [
                    'type' => 'private',
                    'id' => 200,
                ],
                'date' => 0,
            ],
        ]);

        $this->assertInstanceOf(CallbackQuery::class, $callbackQuery);
        $this->assertInstanceOf(InaccessibleMessage::class, $callbackQuery->message);
        $this->assertInstanceOf(Chat::class, $callbackQuery->message->chat);

        $callbackQuery = CallbackQuery::makeFromArray([
            'id' => 'foo',
            'from' => [
                'id' => 100,
                'is_bot' => false,
                'first_name' => 'Mahdi',
            ],
            'chat_instance' => 'something',
            'message' => [
                'message_id' => 400,
                'chat' => [
                    'type' => 'private',
                    'id' => 200,
                ],
                'date' => 1234,
            ],
        ]);

        $this->assertInstanceOf(CallbackQuery::class, $callbackQuery);
        $this->assertInstanceOf(Message::class, $callbackQuery->message);
        $this->assertInstanceOf(Chat::class, $callbackQuery->message->chat);
    }
}