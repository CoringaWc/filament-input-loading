# Filament Input Loading — Agent Guide

## What This Plugin Does

This is a **Filament v2** plugin that extends `Filament\Forms\Components\TextInput` to display a **loading spinner** inside the input field when Livewire is processing a server update triggered by `lazy()` or `debounce()` binding modifiers.

## Architecture

```
src/
├── FilamentInputLoadingProvider.php   # Laravel package service provider (registers views)
└── TextInput.php                      # Extends Filament's TextInput, overrides the Blade view

resources/views/
└── text-input.blade.php               # Custom Blade template with wire:loading spinner injected

tests/
├── TestCase.php                       # Base test case (Orchestra Testbench)
└── Unit/
    ├── TextInputTest.php              # Tests for the TextInput component
    └── ServiceProviderTest.php        # Tests for service provider registration

docker/php/
├── Dockerfile                         # PHP 8.1 + Node 18 (custom for Filament v2)
└── entrypoint.sh                      # Auto-install dependencies on container start

packages/workbench/                    # Git submodule: coringawc/filament-plugin-workbench
```

### Key Components

**TextInput.php** — Minimal class that extends `Filament\Forms\Components\TextInput` and points to a custom Blade view. No additional PHP logic; the entire feature is in the template.

**FilamentInputLoadingProvider.php** — Standard Spatie `PackageServiceProvider`. Registers the package name (`filament-input-loading`) and publishes Blade views under the `filament-input-loading::` namespace. Originally extended `Filament\PluginServiceProvider` (from `filament/filament` admin panel), but was corrected to extend `Spatie\LaravelPackageTools\PackageServiceProvider` since this plugin only depends on `filament/forms`.

**text-input.blade.php** — Copy of Filament v2's original `text-input.blade.php` with one addition: a `<x-filament-support::loading-indicator>` wrapped in `wire:loading` directives (lines 82-94). This indicator:

- Only renders when `$isDebounced()` or `$isLazy()` is `true`
- Uses `wire:loading` + `wire:target="$getStatePath()"` to show/hide the spinner
- Is absolutely positioned at the right side of the input

## Development Environment

This plugin uses [filament-plugin-workbench](https://github.com/CoringaWc/filament-plugin-workbench) as a git submodule with a **custom Docker image** (PHP 8.1 instead of the workbench's default PHP 8.4), because Filament v2 is not compatible with PHP 8.4 or Laravel 12.

### Setup

```bash
git submodule update --init --recursive
./packages/workbench/bin/workbench up
```

### Day-to-day commands

```bash
./packages/workbench/bin/sail phpunit           # Run tests
./packages/workbench/bin/sail phpstan            # Static analysis
./packages/workbench/bin/sail pint               # Code style
./packages/workbench/bin/sail shell              # Interactive shell
```

### Why PHP 8.1?

The workbench default image uses PHP 8.4, but Filament v2 requires Laravel 9.x which does not support PHP 8.4. The custom `docker/php/Dockerfile` pins PHP 8.1 and Node 18 LTS.

## Compatibility

- **Filament**: v2.x only (uses `PluginServiceProvider`, `filament-support::` components, Livewire v2 `$wire.__instance.serverMemo`)
- **PHP**: 8.0+
- **Laravel**: 9.x (via Orchestra Testbench ^7)

## Known Technical Debt

1. **Blade template is a full copy** of Filament v2's TextInput view — any upstream fixes to Filament's TextInput won't propagate
2. **`:key="{{ \Illuminate\Support\Str::random() }}"` on line 42** — generates a new key every render cycle, which forces Alpine.js to reinitialize the input element. This may cause performance issues in forms with many inputs
3. **Livewire v2 internals** — uses `$wire.__instance.serverMemo.errors` which is a Livewire v2 internal API, not available in Livewire v3

## When Modifying This Plugin

- If upgrading to Filament v3+, the entire Blade template must be rewritten (different component structure, Livewire v3 API)
- The `PluginServiceProvider` base class was removed in Filament v3 — use a standard `ServiceProvider` with `Filament\Support\Assets\AssetManager` instead
- The loading indicator component namespace changed from `filament-support::` to `filament::` in v3
- After upgrading to Filament v3+, switch the Dockerfile to the workbench's generic image (remove `docker/php/`) and update `docker-compose.yml` to point to the workbench's Dockerfile
