<?php

declare(strict_types=1);

namespace CoringaWc\FilamentInputLoading\Tests\Unit;

use CoringaWc\FilamentInputLoading\FilamentInputLoadingProvider;
use CoringaWc\FilamentInputLoading\Tests\TestCase;

class ServiceProviderTest extends TestCase
{
    /** @test */
    public function it_registers_the_package(): void
    {
        $this->assertArrayHasKey(
            FilamentInputLoadingProvider::class,
            $this->app->getLoadedProviders()
        );
    }

    /** @test */
    public function it_publishes_views(): void
    {
        $views = $this->app['view']->getFinder()->getHints();

        $this->assertArrayHasKey('filament-input-loading', $views);
    }
}
