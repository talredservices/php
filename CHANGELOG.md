# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/)
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

---

## [1.1.3] - 2026-09-28

### Added

- Added the additive `talred-config` publish tag and `config/talred.php` unified configuration surface.
- Added Talred-named configuration aliases while retaining all Zolta configuration keys and publish tags.

### Changed

- New applications can configure `talred.*`; resolved values remain mirrored to the existing `zolta.*` runtime surface.

## [1.1.2] - 2026-09-28

### Added

- Added the `talred/php` umbrella coordinate for the Talred Forge, CQRS, and HTTP packages.
- Declared `zolta/framework` as a replaced package for dependency compatibility.

### Changed

- Updated umbrella dependencies and repository metadata to the Talred organization.
- Retained the technical `Zolta\Framework` composition-root namespace, provider names, `zolta-config` publish tag, and `config/zolta.php` filename.

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

[Unreleased]: https://github.com/talredservices/php/compare/v1.1.3...HEAD
[1.1.3]: https://github.com/talredservices/php/compare/v1.1.2...v1.1.3
[1.1.2]: https://github.com/talredservices/php/compare/v1.1.1...v1.1.2
[1.1.0]: https://github.com/talredservices/php/compare/v1.0.0...v1.1.0
[1.0.0]: https://github.com/talredservices/php/compare/v0.0.0...v1.0.0
