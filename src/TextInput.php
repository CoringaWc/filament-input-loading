<?php

namespace CoringaWc\FilamentInputLoading;

use Filament\Forms\Components\TextInput as FilamentTextInput;

class TextInput extends FilamentTextInput
{
    protected string $view = 'filament-input-loading::text-input';
}
