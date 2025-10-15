<?php

namespace MemoGram\Tests;

use MemoGram\Providers\MemoGramServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            ...parent::getPackageProviders($app),
            MemoGramServiceProvider::class,
        ];
    }
}
