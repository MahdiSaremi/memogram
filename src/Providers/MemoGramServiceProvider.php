<?php

namespace MemoGram\Providers;

use Carbon\Laravel\ServiceProvider;
use Illuminate\Console\Application as Artisan;
use Revolt\EventLoop;

class MemoGramServiceProvider extends ServiceProvider
{
    /**
     * Register app
     *
     * @return void
     */
    public function register()
    {
        $config = __DIR__ . '/../../config/memogram.php';
        $this->publishes([$config => base_path('config/memogram.php')], ['memogram']);
        $this->mergeConfigFrom($config, 'memogram');

        $this->registerCommands();
        $this->registerLang();

        $this->registerEventLoop();
    }


    protected array $commands = [
    ];

    /**
     * Register commands
     *
     * @return void
     */
    public function registerCommands()
    {
        Artisan::starting(function ($artisan) {
            foreach ($this->commands as $command) {
                $artisan->resolveCommands(app($command));
            }
        });
    }

    public function registerLang()
    {
        $this->publishes([
            __DIR__ . '/../../lang' => $this->app->langPath('vendor/memogram'),
        ], ['memogram:lang', 'lang']);

        $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'memogram');
    }

    public function registerEventLoop()
    {
        $previousErrorHandler = EventLoop::getErrorHandler();
        
        EventLoop::setErrorHandler(function (\Throwable $exception) use ($previousErrorHandler) {
            report($exception);

            if ($previousErrorHandler) {
                $previousErrorHandler($exception);
            } else {
                throw $exception;
            }
        });
    }
}
