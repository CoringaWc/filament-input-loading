[![Latest Version on Packagist](https://img.shields.io/packagist/v/coringawc/filament-input-loading.svg?style=flat-square)](https://packagist.org/packages/coringawc/filament-input-loading)
[![Semantic Release](https://github.com/coringawc/filament-input-loading/actions/workflows/release.yml/badge.svg)](https://github.com/coringawc/filament-input-loading/actions/workflows/release.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/coringawc/filament-input-loading.svg?style=flat-square)](https://packagist.org/packagescoringawc/filament-input-loading)

# Filament Input Loading

Input with option of spinner loading utilizing the 'lazy()' or 'debounce()' methods

## Screenshots

![Screenshot of Login Screen](./screenshots/exemple.png)

## Installation

You can install the package via composer:

```bash
composer require coringawc/filament-input-loading
```

## Usage

`use CoringaWc\FilamentInputLoading\TextInput;`

`TextInput::make('input')->lazy()->...`

or

`TextInput::make('input')->debounce()->...`

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [CoringaWc](https://github.com/coringawc)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
