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
```

### Key Components

**TextInput.php** — Minimal class that extends `Filament\Forms\Components\TextInput` and points to a custom Blade view. No additional PHP logic; the entire feature is in the template.

**FilamentInputLoadingProvider.php** — Standard Spatie Laravel Package Tools provider. Registers the package name (`filament-input-loading`) and publishes Blade views under the `filament-input-loading::` namespace.

**text-input.blade.php** — Copy of Filament v2's original `text-input.blade.php` with one addition: a `<x-filament-support::loading-indicator>` wrapped in `wire:loading` directives (lines 82-94). This indicator:

- Only renders when `$isDebounced()` or `$isLazy()` is `true`
- Uses `wire:loading` + `wire:target="$getStatePath()"` to show/hide the spinner
- Is absolutely positioned at the right side of the input

## Compatibility

- **Filament**: v2.x only (uses `PluginServiceProvider`, `filament-support::` components, Livewire v2 `$wire.__instance.serverMemo`)
- **PHP**: 8.0+
- **Laravel**: Compatible with whatever Filament v2 supports

## Known Technical Debt

1. **Blade template is a full copy** of Filament v2's TextInput view — any upstream fixes to Filament's TextInput won't propagate
2. **`:key="{{ \Illuminate\Support\Str::random() }}"` on line 42** — generates a new key every render cycle, which forces Alpine.js to reinitialize the input element. This may cause performance issues in forms with many inputs
3. **Livewire v2 internals** — uses `$wire.__instance.serverMemo.errors` which is a Livewire v2 internal API, not available in Livewire v3
4. **No tests** — no automated tests exist

## When Modifying This Plugin

- If upgrading to Filament v3+, the entire Blade template must be rewritten (different component structure, Livewire v3 API)
- The `PluginServiceProvider` base class was removed in Filament v3 — use a standard `ServiceProvider` with `Filament\Support\Assets\AssetManager` instead
- The loading indicator component namespace changed from `filament-support::` to `filament::` in v3
