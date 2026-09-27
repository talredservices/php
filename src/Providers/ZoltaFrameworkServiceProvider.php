<?php

declare(strict_types=1);

namespace Zolta\Framework\Providers;

use Illuminate\Support\ServiceProvider;

final class ZoltaFrameworkServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $configPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'zolta.php';

        $defaults = require $configPath;
        $configured = (array) config('zolta', []);

        $this->app['config']->set(
            'zolta',
            array_replace_recursive($defaults, $configured),
        );
    }

    public function boot(): void
    {
        $this->publishes([
            dirname(__DIR__) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'zolta.php' => config_path('zolta.php'),
        ], 'zolta-config');
    }
}
