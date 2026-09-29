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
        $configured = array_replace_recursive(
            (array) config('zolta', []),
            (array) config('talred', []),
        );
        $resolved = array_replace_recursive($defaults, $configured);

        // Talred is the public configuration surface; zolta remains the
        // technical compatibility surface used by the existing runtime.
        $this->app['config']->set('zolta', $resolved);
        $this->app['config']->set('talred', $resolved);
    }

    public function boot(): void
    {
        $this->publishes([
            dirname(__DIR__) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'zolta.php' => config_path('zolta.php'),
        ], 'zolta-config');

        $this->publishes([
            dirname(__DIR__) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'zolta.php' => config_path('talred.php'),
        ], 'talred-config');
    }
}
