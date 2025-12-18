<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NavigationResource\Pages;
use App\Models\Navigation;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Schemas\Components as SchemaComponents;
use Filament\Forms\Components as FormComponents;
use Filament\Actions;
use Filament\Tables;
use Filament\Tables\Table;
use Spatie\Permission\Models\Role;

class NavigationResource extends Resource
{
    protected static ?string $model = Navigation::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-bars-3';
    
    protected static string | \UnitEnum | null $navigationGroup = 'Settings';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                SchemaComponents\Section::make('Menu Details')
                    ->schema([
                        FormComponents\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, \Filament\Schemas\Components\Utilities\Set $set) => $operation === 'create' ? $set('handle', \Illuminate\Support\Str::slug($state)) : null),

                        FormComponents\TextInput::make('handle')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                    ]),

                SchemaComponents\Section::make('Menu Items')
                    ->schema([
                        FormComponents\Repeater::make('items')
                            ->schema(static::getMenuItemSchema())
                            ->defaultItems(0)
                            ->reorderableWithButtons()
                            ->collapsible()
                            ->label('Items'),
                    ]),
            ]);
    }

    public static function getMenuItemSchema(): array
    {
        return [
            SchemaComponents\Grid::make(2)
                ->schema([
                    FormComponents\TextInput::make('label')
                        ->required()
                        ->label('Label'),
                    
                    FormComponents\TextInput::make('url')
                        ->required()
                        ->label('URL')
                        ->placeholder('https://... or /path'),
                        
                    FormComponents\Select::make('target')
                        ->options([
                            '_self' => 'Same Tab',
                            '_blank' => 'New Tab',
                        ])
                        ->default('_self')
                        ->selectablePlaceholder(false),
                        
                    FormComponents\Select::make('roles')
                        ->multiple()
                        ->options(fn () => Role::pluck('name', 'name'))
                        ->label('Visible to Roles')
                        ->placeholder('All Roles'),
                ]),

            FormComponents\Repeater::make('children')
                ->label('Sub Menu')
                ->schema([
                    SchemaComponents\Grid::make(2)
                        ->schema([
                            FormComponents\TextInput::make('label')
                                ->required(),
                            FormComponents\TextInput::make('url')
                                ->required(),
                            FormComponents\Select::make('target')
                                ->options([
                                    '_self' => 'Same Tab',
                                    '_blank' => 'New Tab',
                                ])
                                ->default('_self'),
                            FormComponents\Select::make('roles')
                                ->multiple()
                                ->options(fn () => Role::pluck('name', 'name')),
                        ]),
                ])
                ->defaultItems(0)
                ->reorderableWithButtons()
                ->collapsible(),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('handle')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNavigations::route('/'),
            'create' => Pages\CreateNavigation::route('/create'),
            'edit' => Pages\EditNavigation::route('/{record}/edit'),
        ];
    }
}