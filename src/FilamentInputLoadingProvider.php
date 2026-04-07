<?php

declare(strict_types=1);

namespace CoringaWc\FilamentInputLoading;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentInputLoadingProvider extends PackageServiceProvider
{
    public static string $name = 'filament-input-loading';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)->hasViews();
    }
}
