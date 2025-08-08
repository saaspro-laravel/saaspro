<?php

namespace SaasPro\Filament\RelationManagers;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use SaasPro\Models\History;

class HistoryRelationManager extends RelationManager
{
    protected static string $relationship = 'history';

    public function form(Form $form): Form {
        return $form->schema([
            TextInput::make('entity')
                ->afterStateHydrated(fn(TextInput $component, History $history) => $component->state($history->entity_name)),
            TextInput::make('editor')
                ->afterStateHydrated(fn(TextInput $component, History $history) => $component->state($history->editor_name)),
            TextInput::make('event'),
            Textarea::make('state')
                ->rows(6)
                ->formatStateUsing(fn($state) => json_encode($state))
                ->columnSpanFull(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('user_id')
            ->columns([
                TextColumn::make('entity_name'),
                TextColumn::make('editor_name')
                    ->label('Editor'),
                TextColumn::make('event'),
                TextColumn::make('created_at')
                    ->label("Performed At")
                    ->datetime(),
            ])
            ->modifyQueryUsing(fn(Builder $query) => $query->latest())
            ->filters([
                //
            ])
            ->actions([
                Action::make('View')
                    ->modal(true)
                    ->modalWidth('lg')
                    ->color('gray')
                    ->fillForm(fn (History $record): array => [
                        'state' => $record->state,
                    ])
                    ->form([
                        KeyValue::make('state')
                            ->label('')
                    ])
                    ->disabledForm()
                    ->modalSubmitAction(false),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
