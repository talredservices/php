<?php

declare(strict_types=1);

use Zolta\Http\Authorization\Identity;

return [

    /*
    |--------------------------------------------------------------------------
    | CQRS
    |--------------------------------------------------------------------------
    */

    'cqrs' => [
        'commands' => [
            [
                'path' => app_path('Services'),
                'namespace' => 'App\\Services\\',
            ],
        ],

        'queries' => [
            [
                'path' => app_path('Services'),
                'namespace' => 'App\\Services\\',
            ],
        ],

        'infrastructure_events' => [
            [
                'path' => app_path('Services'),
                'namespace' => 'App\\Services\\',
            ],
        ],

        'cache' => [
            'command' => base_path('bootstrap/cache/command_map.php'),
            'query' => base_path('bootstrap/cache/query_map.php'),
            'event' => base_path('bootstrap/cache/event_map.php'),
        ],

        'cache_manifest' => [
            'command' => base_path('bootstrap/cache/command_map_manifest.php'),
            'query' => base_path('bootstrap/cache/query_map_manifest.php'),
            'event' => base_path('bootstrap/cache/event_map_manifest.php'),
        ],

        'map_cache' => [
            'enabled' => filter_var(
                $_ENV['ZOLTA_MAP_CACHE'] ?? true,
                FILTER_VALIDATE_BOOL,
            ),
            'auto_refresh_env' => ['local', 'testing'],
        ],

        'map_keys' => [
            'command' => 'command.map',
            'query' => 'query.map',
            'event' => 'event.map',
        ],

        'options' => [
            'auto_detect_psr4' => true,
            'write_atomic' => true,
            'file_pattern' => '*.php',

            'exclude_paths' => [
                '**/Persistence/Seeders/**',
                '**/Persistence/Factories/**',
                '**/Persistence/Migrations/**',
                '**/Infrastructure/Persistence/Migrations/**',
                '**/Infrastructure/Repositories/**',
                '**/API/Routes/**',
                '**/Database/**',
                '**/vendor/**',
            ],

            'composer_autoload' => base_path('vendor/autoload.php'),
            'follow_symlinks' => false,
            'verbose_logging' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | HTTP
    |--------------------------------------------------------------------------
    */

    'http' => [
        'routes' => [
            'cache' => [
                'enabled' => filter_var(
                    $_ENV['ZOLTA_ATTR_ROUTE_CACHE'] ?? false,
                    FILTER_VALIDATE_BOOL,
                ),

                'ensure_fresh_on_boot' => env(
                    'ZOLTA_ATTR_ROUTE_ENSURE_FRESH_ON_BOOT',
                    false,
                ),

                'skip_commands' => [
                    'package:discover',
                    'make:zolta-update-namespace',
                ],
            ],

            'paths' => [
                app_path('Services/*/API/Controllers'),
                app_path('Http/Controllers'),
            ],

            'exclude_paths' => [],

            'documentation' => [
                'enabled' => env('ZOLTA_ROUTE_DOCS_ENABLED', false),

                'output_dir' => env(
                    'ZOLTA_ROUTE_DOCS_OUTPUT_DIR',
                    base_path('bootstrap/cache'),
                ),

                'output_file' => env(
                    'ZOLTA_ROUTE_DOCS_OUTPUT_FILE',
                    'openapi.json',
                ),

                'manifest_file' => env(
                    'ZOLTA_ROUTE_DOCS_MANIFEST_FILE',
                    'openapi_manifest.php',
                ),

                'title' => env(
                    'ZOLTA_ROUTE_DOCS_TITLE',
                    env('APP_NAME', 'Laravel') . ' API',
                ),

                'version' => env(
                    'ZOLTA_ROUTE_DOCS_VERSION',
                    env('APP_VERSION', '1.0.0'),
                ),

                'description' => env(
                    'ZOLTA_ROUTE_DOCS_DESCRIPTION',
                    'Auto-generated API documentation from Zolta HTTP route attributes.',
                ),

                'server_url' => env(
                    'ZOLTA_ROUTE_DOCS_SERVER_URL',
                    env('APP_URL', 'http://localhost'),
                ),

                'server_description' => env(
                    'ZOLTA_ROUTE_DOCS_SERVER_DESCRIPTION',
                    'Application server',
                ),
            ],

            'default_response' => null,
        ],

        'sqlite' => [
            'wsl_path' => database_path('database.sqlite'),
            'wsl_windows_path' => env('ZOLTA_SQLITE_WSL_WINDOWS_PATH', '/mnt/c/Users/Public/zolta-sqlite/database.sqlite'),
            'windows_path' => env('ZOLTA_SQLITE_WINDOWS_PATH', 'C:\\Users\\Public\\zolta-sqlite\\database.sqlite'),
            'backup_dir' => env('ZOLTA_SQLITE_BACKUP_DIR', base_path('database/backups')),
            'browser_executable' => env('ZOLTA_SQLITE_BROWSER_EXECUTABLE'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Identity
    |--------------------------------------------------------------------------
    */

    'identity' => [
        'class' => env('ZOLTA_IDENTITY_CLASS', Identity::class),

        'permissions' => [
            // 'roles.*.permissions',
            // 'role.permissions',
            // 'permissions',
        ],

        'schema' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Security
    |--------------------------------------------------------------------------
    */

    'security' => [
        'abilities' => [
            // 'manage_users' => ['users.read', 'users.create', 'users.update', 'users.delete'],
        ],

        'user' => [
            'class' => null,
            'attributes' => [
                'permissions.*.name',
                'role.permissions.*.name',
                'roles.*.permissions.*.name',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Identity Consumer
    |--------------------------------------------------------------------------
    */

    'identity_consumer' => [
        'connections' => [
            'live' => [
                'base_url' => env('IDENTITY_API_URL'),
                'project' => env('IDENTITY_PROJECT'),
                'client_id' => env('IDENTITY_CLIENT_ID'),
                'client_secret' => env('IDENTITY_CLIENT_SECRET'),
            ],
            'sandbox' => [
                'base_url' => env('IDENTITY_SANDBOX_API_URL', env('IDENTITY_API_URL')),
                'project' => env('IDENTITY_SANDBOX_PROJECT'),
                'client_id' => env('IDENTITY_SANDBOX_CLIENT_ID'),
                'client_secret' => env('IDENTITY_SANDBOX_CLIENT_SECRET'),
            ],
        ],
        'timeout_seconds' => (int) env('IDENTITY_INTROSPECTION_TIMEOUT_SECONDS', 5),
        'cache_seconds' => (int) env('IDENTITY_INTROSPECTION_CACHE_SECONDS', 30),
        'webhook_secrets' => array_values(array_filter(array_map(
            static fn(string $secret): string => trim($secret),
            explode(',', (string) env('IDENTITY_WEBHOOK_SECRETS', '')),
        ))),
        'webhook_tolerance_seconds' => (int) env('IDENTITY_WEBHOOK_TOLERANCE_SECONDS', 300),
    ],
];
