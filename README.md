# Zolta Framework

`zolta/framework` is the umbrella package for the Zolta ecosystem. It installs the core Zolta components and ships a unified Laravel configuration entrypoint.

## Installed Packages

This package includes the following Zolta components:

- `zolta/forge`
- `zolta/http`
- `zolta/cqrs`

## Installation

To install the complete Zolta framework, you can use Composer:

```bash
composer require zolta/framework
```

If you wish to install individual components, you can do so by requiring them directly:

```bash
composer require zolta/forge
composer require zolta/http
composer require zolta/cqrs
```

## Configuration Publishing

For Laravel applications, publish the unified Zolta configuration with:

```bash
php artisan vendor:publish --tag=zolta-config
```

Tag meanings:

- `zolta-config`: publishes the unified framework configuration (`config/zolta.php`).
- `zolta-cqrs-config`: publishes the CQRS package configuration only.

## Version Compatibility

The versions of the Zolta framework are designed to be compatible with specific versions of the individual components. Please refer to the `composer.json` file for detailed version constraints and compatibility information.

## Maintenance and Releases

The `CHANGELOG.md` file documents all notable changes to this project. It follows the conventions of Keep a Changelog and is updated with each release.

For any issues or contributions, please refer to the project's GitHub repository.