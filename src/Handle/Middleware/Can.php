<?php

namespace MemoGram\Handle\Middleware;

use Illuminate\Support\Facades\Gate;

class Can implements Middleware
{
    protected array $abilities;

    public function __construct(
        ...$abilities,
    )
    {
        $this->abilities = $abilities;
    }

    public function handle(\Closure $next): mixed
    {
        foreach ($this->abilities as $ability) {
            Gate::authorize($ability);
        }

        return $next();
    }
}