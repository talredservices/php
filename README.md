# Zolta Framework

`zolta/framework` is a Composer meta-package that serves as an umbrella installer for the Zolta framework. This package does not contain any runtime source code but instead manages the installation of various Zolta components.

## Installed Packages

This meta-package includes the following Zolta packages:

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

## Version Compatibility

The versions of the Zolta framework are designed to be compatible with specific versions of the individual components. Please refer to the `composer.json` file for detailed version constraints and compatibility information.

## Maintenance and Releases

The `CHANGELOG.md` file documents all notable changes to this project. It follows the conventions of Keep a Changelog and will be updated with each release to reflect changes in the meta-package.

For any issues or contributions, please refer to the project's GitHub repository.