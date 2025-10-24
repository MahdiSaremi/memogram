<?php

namespace MemoGram\Handle\Middleware;

use Illuminate\Support\Facades\Gate;

class Cannot implements Middleware
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
            Gate::allows($ability) && abort(403);
        }

        return $next();
    }
}