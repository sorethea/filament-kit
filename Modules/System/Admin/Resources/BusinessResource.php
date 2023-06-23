<?php

namespace Modules\System\Admin\Resources;

use App\Models\User;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Hash;
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
use Modules\System\Traits\Utility;
use Modules\System\Utilities\BusinessUtil;

class BusinessResource extends Resource
{

    protected static ?string $model = Business::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';


    protected static function getNavigationGroup(): ?string
    {
        return config('system.groups.admin');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Company')->schema([
                    Forms\Components\TextInput::make('name')
                        ->unique('businesses','name',fn($record)=>$record)
                        ->required(),
                    Forms\Components\DatePicker::make('start_date')
                        ->required(),
                    Forms\Components\Select::make('currency_id')
                        ->relationship('currency','code')
                        ->default(124)
                        ->required(),
                    Forms\Components\FileUpload::make('logo')
                        ->directory('uploads/businesses')
                        ->image(),
                    Forms\Components\Repeater::make('locations')
                        ->relationship('locations')
                        ->schema([
                        Forms\Components\TextInput::make('landmark')
                            ->required(),
                        Forms\Components\TextInput::make('mobile')
                            ->rule('digits_between:9,10')
                            ->required(),
                        Forms\Components\TextInput::make('city')
                            ->required(),
                            ])->columnSpan(2)->columns(3),

                ])->columns(2),
                Forms\Components\Section::make('System User')
                    ->relationship('owner')
                    ->schema([
                    Forms\Components\TextInput::make('first_name')
                        ->required(),
                    Forms\Components\TextInput::make('last_name')
                        ->nullable(),
                    Forms\Components\TextInput::make('email')
                        ->unique('users','email',fn($record)=>$record)
                        ->required(),
                    Forms\Components\TextInput::make('user_name')
                        ->unique('users', 'user_name',fn($record)=>$record)
                        ->nullable(),
                    TextInput::make('password')->label(trans('system::user.resource.password'))
                        ->password()
                        ->hiddenOn('edit')
                        ->maxLength(255)
                        ->dehydrateStateUsing(static function ($state) use ($form){
                            if(!empty($state)){
                                return Hash::make($state);
                            }

                            $user = User::find($form->getColumns());
                            if($user){
                                return $user->password;
                            }
                        })
                        ->required(fn($record)=>!$record),
                    TextInput::make('password_confirm')
                        ->label(trans('system::user.resource.password_confirmation'))
                        ->maxLength(255)
                        ->hiddenOn('edit')
                        ->password()
                        ->same('password')
                        ->required(fn($record)=>!$record),
                ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo')
                    ->rounded(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('currency.code'),
                Tables\Columns\TextColumn::make('locations.landmark')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('M/d/m/y H:i'),
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
