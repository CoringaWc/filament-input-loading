<?php

declare(strict_types=1);

namespace CoringaWc\FilamentInputLoading\Tests;

use CoringaWc\FilamentInputLoading\FilamentInputLoadingProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            FilamentInputLoadingProvider::class,
        ];
    }
}
