<?php

namespace MemoGram\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use MemoGram\Core\Bot;
use MemoGram\Core\BotChanneling;
use MemoGram\Core\Updates\Update;

class WebhookController extends Controller
{

    public function update(string $hookToken, Request $request)
    {
        return app(BotChanneling::class)->onRoute($hookToken, $request);
    }

}
