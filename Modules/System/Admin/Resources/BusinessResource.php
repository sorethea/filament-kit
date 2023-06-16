<?php

namespace Modules\System\Admin\Resources;

use Modules\System\Admin\Resources\BusinessResource\Pages;
use Modules\System\Admin\Resources\BusinessResource\RelationManagers;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Modules\System\Models\Business;

class BusinessResource extends Resource
{
    protected static ?string $model = Business::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';


    protected static function getNavigationGroup(): ?string
    {
        return config('filament-user.group');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\TextInput::make('name')
                        ->unique('businesses','name',fn($record)=>$record)
                        ->required(),
                    Forms\Components\DatePicker::make('start_date')
                        ->required(),
                    Forms\Components\Select::make('currency')
                        ->options(config('system.currencies'))
                        ->default('USD')
                        ->required(),
                    Forms\Components\FileUpload::make('logo')
                        ->image(),
                ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListBusinesses::route('/'),
            'create' => Pages\CreateBusiness::route('/create'),
            'edit' => Pages\EditBusiness::route('/{record}/edit'),
        ];
    }
}
