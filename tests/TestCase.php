<?php

namespace MemoGram\Tests;

use MemoGram\Api\TelegramApi;
use MemoGram\Handle\EventHandler;
use MemoGram\Providers\MemoGramServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    public TelegramApi $api;
    public EventHandler $eventHandler;

    protected function setUp(): void
    {
        parent::setUp();
        $this->api = new TelegramApi('Foo');
        $this->eventHandler = new EventHandler($this->api);
    }

    protected function getPackageProviders($app)
    {
        return [
            ...parent::getPackageProviders($app),
            MemoGramServiceProvider::class,
        ];
    }
}
