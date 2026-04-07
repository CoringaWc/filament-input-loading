<?php

declare(strict_types=1);

namespace CoringaWc\FilamentInputLoading;

use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;

class FilamentInputLoadingProvider extends PluginServiceProvider
{
    public static string $name = 'filament-input-loading';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)->hasViews();
    }
}
