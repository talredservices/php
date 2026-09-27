<?php

declare(strict_types=1);

namespace Zolta\Framework\Tests\Integration;

use Illuminate\Support\ServiceProvider;
use Orchestra\Testbench\TestCase;
use Zolta\Cqrs\Laravel\Providers\ZoltaCqrsServiceProvider;
use Zolta\Framework\Providers\ZoltaFrameworkServiceProvider;
use Zolta\Http\Authorization\Identity;
use Zolta\Http\Identity\Laravel\Providers\ZoltaIdentityServiceProvider;
use Zolta\Http\Service\Laravel\Providers\ZoltaHttpServiceProvider;

final class ZoltaFrameworkServiceProviderTest extends TestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            ZoltaFrameworkServiceProvider::class,
            ZoltaCqrsServiceProvider::class,
            ZoltaHttpServiceProvider::class,
            ZoltaIdentityServiceProvider::class,
        ];
    }

    public function test_unified_defaults_are_available_to_component_providers(): void
    {
        $this->assertSame(Identity::class, config('zolta.identity.class'));
        $this->assertSame(config('zolta.cqrs.commands'), config('zolta.commands'));
        $this->assertSame(config('zolta.http.routes'), config('zolta-http.routes'));
        $this->assertSame(config('zolta.identity_consumer.connections'), config('identity-consumer.connections'));
    }

    public function test_application_overrides_are_merged_with_the_unified_defaults(): void
    {
        $this->app['config']->set('zolta', [
            'http' => [
                'routes' => [
                    'exclude_paths' => ['app/Legacy/Controllers'],
                ],
            ],
        ]);

        (new ZoltaFrameworkServiceProvider($this->app))->register();

        $this->assertSame(['app/Legacy/Controllers'], config('zolta.http.routes.exclude_paths'));
        $this->assertSame(Identity::class, config('zolta.identity.class'));
        $this->assertNotEmpty(config('zolta.cqrs.commands'));
    }

    public function test_unified_configuration_is_registered_under_the_framework_publish_tag(): void
    {
        $published = ServiceProvider::pathsToPublish(
            ZoltaFrameworkServiceProvider::class,
            'zolta-config',
        );

        $this->assertSame([
            dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'zolta.php' => config_path('zolta.php'),
        ], $published);
    }
}
