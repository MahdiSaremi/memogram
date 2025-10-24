<?php

namespace MemoGram\Handle\Middleware;

interface Middleware
{
    public function handle(\Closure $next): mixed;
}