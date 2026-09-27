# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/)
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

---

## [Unreleased]

### Changed
- Prepared the Composer package migration from `zolta/framework` to `talred/php`.
- Updated component requirements to `talred/forge`, `talred/cqrs`, and `talred/http` beta coordinates while retaining internal `Zolta\\Framework\\...` namespaces.

---

## [1.1.0] - 2026-08-11

### Added
- Added a Laravel service provider and the publishable unified `zolta-config` configuration file
- Added unified CQRS, HTTP, security, identity, and Identity-consumer configuration defaults
- Added integration coverage confirming that the unified configuration is exposed through the component providers

### Changed
- The framework package is now a Composer library so it can provide Laravel configuration at runtime
- Updated component requirements to `zolta/forge ^1.0`, `zolta/cqrs ^2.1`, and `zolta/http ^2.1`

---

## [1.0.0] - 2026-08-02

### Added
- Initial release of `zolta/framework` as a Composer meta-package.
- Included dependencies: `zolta/forge`, `zolta/http`, `zolta/cqrs`.

### Changed
- N/A

### Fixed
- N/A

### Security
- N/A

---

## Version comparison links

[Unreleased]: https://github.com/zoltasoft/framework/compare/v1.1.0...HEAD
[1.1.0]: https://github.com/zoltasoft/framework/compare/v1.0.0...v1.1.0
[1.0.0]: https://github.com/zoltasoft/framework/compare/v0.0.0...v1.0.0
