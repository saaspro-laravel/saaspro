<?php

namespace Utyemma\SaasPro\Filament\Forms\Components;

use Utyemma\SaasPro\Enums\PaymentMethods;
use Utyemma\SaasPro\Models\Currency;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Select;

class SelectCurrency extends Select {

    protected function setUp() : void {
        parent::setUp();

        $this->options = Currency::pluck('name', 'code');
    }

}
