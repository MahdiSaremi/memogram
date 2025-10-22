<?php

namespace MemoGram\Tests\Handle;

use Illuminate\Foundation\Testing\RefreshDatabase;
use MemoGram\Handle\Page;
use MemoGram\Handle\State;
use MemoGram\Matching\ListenerMatcher;
use MemoGram\Models\PageCellModel;
use MemoGram\Models\PageModel;
use MemoGram\Models\PageUseModel;
use MemoGram\Tests\TestCase;
use function MemoGram\Hooks\open;
use function MemoGram\Hooks\useVersion;
use function MemoGram\Handle\{page, event};

class PageTest extends TestCase
{
    use RefreshDatabase;

    public function testCallingPage()
    {
        $event = new FakeEvent(1, 1, 1);

        $this->eventHandler->handleUsing($event, function () {
            $page = new Page(_PageTestClass::class . '@testCallingPage');
            $page->mount([]);
        });

        $this->assertTrue(_PageTestClass::$a->respond);
        $this->assertFalse(_PageTestClass::$a->listened);
        $this->assertFalse(_PageTestClass::$a->refreshed);
        $this->assertSame("This is a test.", _PageTestClass::$a->value);

        $pageModel = PageModel::query()->first();
        $pageUse = PageUseModel::query()->first();
        $pageCells = PageCellModel::query()->get();

        $this->assertSame(_PageTestClass::class . '@testCallingPage', $pageModel->reference);
        $this->assertSame([], $pageModel->states);
        $this->assertSame($pageModel->id, $pageUse->page_id);
        $this->assertSame(1, $pageUse->chat_id);
        $this->assertCount(1, $pageCells);
        $this->assertSame($pageUse->id, $pageCells[0]->use_id);
        $this->assertSame(0, $pageCells[0]->message_id);
    }

    public function testCallingPageWithState()
    {
        $event = new FakeEvent(1, 1, 1);

        $this->eventHandler->handleUsing($event, function () {
            $page = new Page(_PageTestClass::class . '@testCallingPageWithState');
            $page->mount([]);
        });

        $this->assertTrue(_PageTestClass::$a->respond);
        $this->assertFalse(_PageTestClass::$a->listened);
        $this->assertFalse(_PageTestClass::$a->refreshed);
        $this->assertSame("State: 0", _PageTestClass::$a->value);

        $pageModel = PageModel::query()->first();
        $pageUse = PageUseModel::query()->first();
        $pageCells = PageCellModel::query()->get();

        $this->assertSame(_PageTestClass::class . '@testCallingPageWithState', $pageModel->reference);
        $this->assertSame([0], $pageModel->states);
        $this->assertSame($pageModel->id, $pageUse->page_id);
        $this->assertSame(1, $pageUse->chat_id);
        $this->assertCount(1, $pageCells);
        $this->assertSame($pageUse->id, $pageCells[0]->use_id);
        $this->assertSame(0, $pageCells[0]->message_id);
    }

    public function testHydrateAndUpdateState()
    {
        $event = new FakeEvent(1, 1, 1);

        $this->eventHandler->handleUsing($event, function () use ($event) {
            $page = new Page(_PageTestClass::class . '@testHydrateAndUpdateState');
            $page->mount([]);

            $page = new Page(_PageTestClass::class . '@testHydrateAndUpdateState');
            $page->hydrate(PageUseModel::first());
            $page->pushHydratedEvent($event, fn() => null);
        });

        $this->assertTrue(_PageTestClass::$a->respond);
        $this->assertTrue(_PageTestClass::$a->refreshed);
        $this->assertSame("State: 1", _PageTestClass::$a->value);

        $pageModel = PageModel::query()->first();
        $pageUse = PageUseModel::query()->first();
        $pageCells = PageCellModel::query()->get();

        $this->assertSame(_PageTestClass::class . '@testHydrateAndUpdateState', $pageModel->reference);
        $this->assertSame([1], $pageModel->states);
        $this->assertSame($pageModel->id, $pageUse->page_id);
        $this->assertSame(1, $pageUse->chat_id);
        $this->assertCount(1, $pageCells);
        $this->assertSame($pageUse->id, $pageCells[0]->use_id);
        $this->assertSame(0, $pageCells[0]->message_id);
    }

    public function testTwoUsersUseTheSamePage()
    {
        $event1 = new FakeEvent(1, 1, 1);
        $event2 = new FakeEvent(2, 2, 2);

        $this->eventHandler->handleUsing($event1, function () use ($event1) {
            $page = new Page(_PageTestClass::class . '@testCallingPage');
            $page->mount([]);
        });

        $this->eventHandler->handleUsing($event2, function () use ($event2) {
            $page = new Page(_PageTestClass::class . '@testCallingPage');
            $page->mount([]);
        });

        $pageModel = PageModel::query()->get();

        $this->assertCount(1, $pageModel);
        $this->assertSame(_PageTestClass::class . '@testCallingPage', $pageModel[0]->reference);
        $this->assertSame([], $pageModel[0]->states);

        $this->assertCount(2, $pageModel[0]->uses);
        $this->assertSame(1, $pageModel[0]->uses[0]->chat_id);
        $this->assertSame(2, $pageModel[0]->uses[1]->chat_id);

        $this->assertCount(1, $pageModel[0]->uses[0]->cells);
        $this->assertCount(1, $pageModel[0]->uses[1]->cells);
        $this->assertSame(0, $pageModel[0]->uses[0]->cells[0]->message_id);
        $this->assertSame(0, $pageModel[0]->uses[1]->cells[0]->message_id);
    }

    public function testTwoUsersUseTheSamePageWithDifferentStates()
    {
        $event1 = new FakeEvent(1, 1, 1);
        $event2 = new FakeEvent(2, 2, 2);

        $this->eventHandler->handleUsing($event1, function () use ($event1) {
            $page = new Page(_PageTestClass::class . '@testCallingSpecialPageForTheUser');
            $page->mount([]);
        });

        $this->eventHandler->handleUsing($event2, function () use ($event2) {
            $page = new Page(_PageTestClass::class . '@testCallingSpecialPageForTheUser');
            $page->mount([]);
        });

        $pageModel = PageModel::query()->get();

        $this->assertCount(2, $pageModel);
        $this->assertSame(_PageTestClass::class . '@testCallingSpecialPageForTheUser', $pageModel[0]->reference);
        $this->assertSame(_PageTestClass::class . '@testCallingSpecialPageForTheUser', $pageModel[1]->reference);
        $this->assertSame([1], $pageModel[0]->states);
        $this->assertSame([2], $pageModel[1]->states);
    }

    public function testTwoUsersUseTheSamePageWithChangingToSameStates()
    {
        $event1 = new FakeEvent(1, 1, 1);
        $event2 = new FakeEvent(2, 2, 2);

        $this->eventHandler->handleUsing($event1, function () use ($event1) {
            $page = new Page(_PageTestClass::class . '@testCallingSpecialPageForTheUser');
            $page->mount([]);
        });

        $this->eventHandler->handleUsing($event2, function () use ($event2) {
            $page = new Page(_PageTestClass::class . '@testCallingSpecialPageForTheUser');
            $page->mount([]);

            $page = new Page(_PageTestClass::class . '@testCallingSpecialPageForTheUser');
            $page->hydrate(PageUseModel::where('chat_id', 2)->first());
            $page->pushHydratedEvent($event2, fn() => null);
        });

        $pageModel = PageModel::query()->get();

        $this->assertCount(1, $pageModel);
        $this->assertSame(_PageTestClass::class . '@testCallingSpecialPageForTheUser', $pageModel[0]->reference);
        $this->assertSame([1], $pageModel[0]->states);
        $this->assertCount(2, $pageModel[0]->uses);
    }

    public function testUsingVersion()
    {
        $event = new FakeEvent(1, 1, 1);

        $this->eventHandler->handleUsing($event, function () {
            open([_PageTestClass::class, 'testUsingVersion']);
        });

        $pageModel = PageModel::query()->first();

        $this->assertSame(_PageTestClass::class . '@testUsingVersion', $pageModel->reference);
        $this->assertSame([], $pageModel->states);
        $this->assertSame('2.1.4', $pageModel->version);
    }
}

class _PageTestClass
{
    public static FakeResponse $a;
    public static FakeResponse $b;

    public function testCallingPage()
    {
        return static::$a = new FakeResponse("This is a test.");
    }

    public function testUsingVersion()
    {
        useVersion('2.1.4');
        return static::$a = new FakeResponse("This is a test.");
    }

    public function testCallingPageWithState()
    {
        /** @var State<string> $foo */
        $foo = page()->useState(0);

        return static::$a = new FakeResponse("State: {$foo->value}");
    }

    public function testHydrateAndUpdateState()
    {
        /** @var State<string> $foo */
        $foo = page()->useState(0);

        page()->listenUsing(function (ListenerMatcher $match) use ($foo) {
            $match->onAny(function () use ($foo) {
                $foo->value++;
                page()->refresh();
            });
        });

        return static::$a = new FakeResponse("State: {$foo->value}");
    }

    public function testCallingSpecialPageForTheUser()
    {
        $userId = page()->useState(fn() => event()->getUserId());

        page()->listenUsing(function (ListenerMatcher $match) use ($userId) {
            $match->onAny(function () use ($userId) {
                $userId->value--;
                page()->refresh();
            });
        });

        return static::$a = new FakeResponse("This is a test for {$userId->value}.");
    }
}