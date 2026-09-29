# Talred PHP

`talred/php` is the umbrella package for the Talred ecosystem. It installs the core Talred components and ships a unified Laravel configuration entrypoint.

## Installed Packages

This package includes the following Talred components:

- `talred/forge`
- `talred/http`
- `talred/cqrs`

## Installation

To install the complete Talred PHP stack, you can use Composer:

```bash
composer require talred/php
```

If you wish to install individual components, you can do so by requiring them directly:

```bash
composer require talred/forge
composer require talred/http
composer require talred/cqrs
```

## Configuration Publishing

For Laravel applications, publish the unified Talred configuration with:

```bash
php artisan vendor:publish --tag=zolta-config
```

Tag meanings:

- `zolta-config`: publishes the unified framework configuration (`config/zolta.php`).

When you install `talred/php`, use `zolta-config`; it includes configuration for CQRS, HTTP, security, Identity, and the Identity consumer. The publish tag and `config/zolta.php` filename remain technical compatibility identifiers. Package-specific tags are intended for applications that install an individual component directly.

## Compatibility

The umbrella package keeps its technical `Zolta\Framework` composition-root
and provider names unchanged. This avoids colliding with Forge’s public
`Talred\Framework` adapter namespace. Compatibility-enabled Forge, CQRS, and
HTTP releases are intended to expose their additive Talred namespaces while
existing Zolta imports continue to work. The checked-out package sources have
been validated locally; those compatibility-enabled releases must be published
before an installed umbrella graph can resolve `Talred\...` imports.

## Version Compatibility

The versions of Talred PHP are designed to be compatible with specific versions of the individual components. Please refer to `composer.json` for detailed version constraints and compatibility information.

## Maintenance and Releases

The `CHANGELOG.md` file documents all notable changes to this project. It follows the conventions of Keep a Changelog and is updated with each release.

For any issues or contributions, please refer to the project's GitHub repository.
