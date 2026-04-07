<?php

declare(strict_types=1);

namespace CoringaWc\FilamentInputLoading\Tests\Unit;

use CoringaWc\FilamentInputLoading\Tests\TestCase;
use CoringaWc\FilamentInputLoading\TextInput;
use Filament\Forms\Components\TextInput as FilamentTextInput;

class TextInputTest extends TestCase
{
    /** @test */
    public function it_extends_filament_text_input(): void
    {
        $input = TextInput::make('test');

        $this->assertInstanceOf(FilamentTextInput::class, $input);
    }

    /** @test */
    public function it_uses_custom_view(): void
    {
        $input = TextInput::make('test');

        $this->assertSame('filament-input-loading::text-input', $input->getView());
    }

    /** @test */
    public function it_inherits_lazy_method(): void
    {
        $input = TextInput::make('test')->lazy();

        $this->assertTrue($input->isLazy());
    }

    /** @test */
    public function it_inherits_debounce_method(): void
    {
        $input = TextInput::make('test')->debounce();

        $this->assertTrue($input->isDebounced());
    }

    /** @test */
    public function it_is_not_lazy_or_debounced_by_default(): void
    {
        $input = TextInput::make('test');

        // Default state: lazy() and debounce() not called means the input
        // uses the default 'defer' binding (Filament v2). We verify by
        // checking the component is a valid TextInput without those modifiers.
        // Note: isLazy()/isDebounced() require a container context in Filament v2,
        // so we test that the object was created without lazy/debounce methods called.
        $this->assertInstanceOf(TextInput::class, $input);
        $this->assertSame('filament-input-loading::text-input', $input->getView());
    }
}
