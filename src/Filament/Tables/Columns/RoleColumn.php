<?php

namespace Utyemma\SaasPro\Filament\Tables\Columns;

use Filament\Tables\Columns\TextColumn;

class RoleColumn extends TextColumn {

    function getState(): mixed {
        $record = $this->record[$this->name];
        return $record->label();
    }

}
