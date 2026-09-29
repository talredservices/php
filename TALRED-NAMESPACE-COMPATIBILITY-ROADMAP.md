# Talred namespace compatibility roadmap

## Decision

Talred is the public brand and the public Composer vendor namespace. The
existing `Zolta\\*` PHP namespaces remain the canonical implementation and
compatibility surface until a separate, explicitly versioned retirement
project is approved.

This is an additive migration. It must allow the current applications to keep
running while new applications and public documentation adopt `Talred\\*`.

## Naming policy

- Public brand and prose: **Talred**.
- English descriptions: **Talred services**.
- French descriptions: **Services Talred**.
- Composer package coordinates: `talred/php`, `talred/forge`, `talred/cqrs`,
  and `talred/http`.
- New PHP examples: `Talred\\*`, backed by compatibility aliases.
- Existing PHP implementation: `Zolta\\*`.
- Existing Laravel provider names, `zolta.php`, `zolta:*` commands, generated
  cache formats, and adapter metadata remain stable until a later migration.
- Legacy `zolta/*` package names appear only in migration or compatibility
  documentation, not in the primary installation path.

## Compatibility architecture

Composer PSR-4 mappings alone cannot rename a PHP namespace. Mapping both
`Zolta\\Http\\` and `Talred\\Http\\` to the same source directory would load
the file, but the file would still declare `Zolta\\...` and PHP would not find
the requested `Talred\\...` symbol.

Each package therefore keeps its existing PSR-4 mapping and registers a small
compatibility autoloader. When a `Talred\\...` symbol is requested, the loader
resolves the corresponding `Zolta\\...` symbol and creates a `class_alias`.
This keeps one implementation and one runtime identity while exposing both
namespaces.

The compatibility layer must cover classes, interfaces, traits, attributes,
exceptions, and enums where the package exposes them. It must never duplicate
business logic or silently rewrite serialized data.

## Package rollout

1. **Forge**: establish the shared compatibility-loader pattern and expose
   `Talred\\Framework`, `Talred\\Domain`, `Talred\\Exceptions`,
   `Talred\\Support`, and related public symbols.
2. **HTTP**: expose `Talred\\Http` aliases, switch the package coordinate to
   `talred/http`, and update public examples. Keep providers and adapter keys
   under `Zolta` for runtime stability.
3. **CQRS**: expose `Talred\\Cqrs` aliases after Forge compatibility is
   available; update its dependency to `talred/forge`.
4. **PHP umbrella**: keep `talred/php` as the distribution package and expose
   its public compatibility surface only after its three dependencies are
   verified.
5. **Consumers**: update application Composer manifests and locks, regenerate
   package discovery, Zolta route/map caches, and OpenAPI artifacts inside the
   canonical guest runtime.
6. **Retirement planning**: only after adoption evidence exists, design a
   future major release that can remove `Zolta\\*` aliases. That is a separate
   breaking-change project.

## Public documentation rules

Primary installation commands and new code examples use `talred/*` and
`Talred\\*`. Every package guide that uses the new namespace should include a
short compatibility note explaining that the implementation still uses
`Zolta\\*` internally. Historical `zolta/*` commands remain only in migration
tables or legacy sections.

Do not replace technical runtime identifiers blindly. Provider class names,
configuration filenames, Artisan command names, serialized class names, route
cache payloads, and existing application imports are compatibility contracts.

## Watch list

- Composer lockfiles must resolve only the intended `talred/*` graph.
- Published package metadata must use the Talred repository URLs and never
  overwrite an existing tag.
- Alias loading must work before the first class reference and must preserve
  interfaces, traits, attributes, exceptions, and enums.
- Reflection and stack traces may still show the canonical `Zolta\\*` class;
  this is expected during the compatibility phase.
- Serialized jobs, events, cache entries, and database fields may contain
  fully-qualified `Zolta\\*` names; do not rewrite them automatically.
- Laravel provider discovery, `extra.zolta-framework-adapter`, `config/zolta.php`,
  and `zolta:*` commands must remain functional.
- Generated package, route, map, OpenAPI, and framework caches must be
  regenerated through their installed commands, never hand-edited.
- Application tests must prove that both old and new imports execute the same
  behavior and that existing Zolta imports remain green.
- Dirty worktrees and retired application backups must not be overwritten or
  silently included in the active migration.

## HTTP pilot acceptance criteria

- `composer.json` identifies the package as `talred/http` and depends on
  `talred/forge`.
- The lockfile resolves the Talred package graph.
- Existing `Zolta\\Http\\...` imports remain valid.
- Representative `Talred\\Http\\...` class, interface, trait, attribute, and
  exception imports resolve to the existing implementation.
- HTTP unit and integration tests pass.
- Public HTTP README and module examples use Talred naming while explaining
  the Zolta compatibility layer.
- `git diff --check` is clean.

## Forge pilot acceptance criteria

- `composer.json` identifies the package as `talred/forge` and replaces
  `zolta/forge` for dependency compatibility.
- Existing `Zolta\\...` imports remain valid.
- Representative Talred classes, interfaces, traits, attributes, exceptions,
  framework services, DTOs, and a real Value Object resolution flow resolve to
  the existing implementation.
- Public Forge README and module examples use Talred naming while technical
  adapter metadata remains stable.
- Unit, static-analysis, lint, PHPMD, Composer validation, and diff checks are
  green; any pre-existing Rector findings remain separately documented.

## Rollback

If the pilot fails, remove only the compatibility loader and its tests, restore
the package coordinate/lockfile from the pre-pilot branch, and leave all
consumer applications untouched. No production deployment or package release
is part of this pilot.

## Verified implementation status

The HTTP pilot has been implemented in `packages/http` without changing any
consumer application or deployment checkout:

- Package identity is `talred/http` and the dependency is `talred/forge`.
- Talred-facing HTTP documentation and examples are in place.
- The additive loader resolves representative classes, interfaces, traits,
  attributes, and exceptions while preserving the Zolta implementation.
- Full PHPUnit: 167 tests, 384 assertions passed.
- Integration PHPUnit: 3 tests, 8 assertions passed.
- Pint, PHPStan, PHP Mess Detector, Rector dry-run, Composer validation, and
  `git diff --check` passed.
- The Composer lock was regenerated locally; this package repository ignores
  `composer.lock`, so it is not a tracked artifact.
- The package has not been published, pushed, or deployed.

The CQRS pilot has also been implemented in `packages/cqrs` without changing
any consumer application or deployment checkout:

- Package identity is `talred/cqrs`, its dependency is `talred/forge`, and
  `zolta/cqrs` is declared as replaced.
- The additive loader maps `Talred\\Cqrs\\...` and Laravel/support variants to
  the existing Zolta implementation; technical publish tags, config filenames,
  provider names, and `zolta.*` settings remain stable.
- Five compatibility tests passed, including functional `Talred` Result
  behavior; the full suite passed with 82 PHPUnit tests and 139 assertions,
  including 7 integration tests.
- PHPStan debug analysis, PHPMD, Pint, Rector, Composer validation, and
  `git diff --check` passed.
- The normal PHPStan wrapper remains affected by the local ephemeral TCP bind
  issue; debug mode completed with no errors.
- The package has not been published, pushed, or deployed.

The Forge pilot has also been implemented in `packages/forge` without changing
any consumer application or deployment checkout:

- Package identity is `talred/forge`, with `zolta/forge` declared as replaced.
- The additive loader maps the public Talred Forge namespaces to the existing
  Zolta implementation without changing the PSR-4 source mappings.
- Seven compatibility tests, including the Value Object smoke flow, passed;
  the full suite passed with 59 PHPUnit tests and 90 assertions.
- PHPStan debug analysis, PHPMD, Pint, Composer validation, and
  `git diff --check` passed.
- The normal PHPStan wrapper remains affected by a local ephemeral TCP bind
  issue; debug mode completed with no errors.
- Rector dry-run still reports three pre-existing suggestions in untouched
  Forge source files; no unrelated source was changed.
- The package has not been published, pushed, or deployed.

The umbrella package metadata has been migrated to `talred/php` and its local
lock graph now resolves `talred/forge`, `talred/cqrs`, and `talred/http`:

- Existing umbrella integration tests pass: 3 tests, 8 assertions.
- The installed public package tags currently lack the compatibility loader
  files from the local package checkouts; representative `Talred\\Domain`,
  `Talred\\Cqrs`, and `Talred\\Http` imports therefore do not resolve from
  the installed umbrella graph yet.
- Publishing the compatibility-enabled Forge, CQRS, and HTTP releases, then
  reinstalling the umbrella graph, is required before marking the umbrella
  public namespace smoke test complete.
- No package was published, pushed, or deployed by this work.
