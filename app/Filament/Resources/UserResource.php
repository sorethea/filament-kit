<?php

namespace App\Filament\Resources;

use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Hash;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BooleanColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use STS\FilamentImpersonate\Impersonate;

class UserResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = User::class;

    protected static ?int $navigationSort = 9;

    protected static $permissionsCollection;

    protected static ?string $navigationIcon = 'heroicon-o-lock-closed';

    protected static function getNavigationLabel(): string
    {
        return trans('filament-user::user.resource.label');
    }

    public static function getPluralLabel(): string
    {
        return trans('filament-user::user.resource.label');
    }

    public static function getLabel(): string
    {
        return trans('filament-user::user.resource.single');
    }

    protected static function getNavigationGroup(): ?string
    {
        return config('system.groups.admin');
    }

    protected function getTitle(): string
    {
        return trans('filament-user::user.resource.title.resource');
    }

    public static function form(Form $form): Form
    {
        $rows = [
            Forms\Components\Card::make()->schema([
                TextInput::make('name')->required()->label(trans('filament-user::user.resource.name')),
                TextInput::make('email')->email()->required()->label(trans('system::user.resource.email')),
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
                    }),
                TextInput::make('password_confirm')
                    ->label(trans('system::user.resource.password_confirmation'))
                    ->hiddenOn('edit')
                    ->maxLength(255)
                    ->password()
                    ->same('password')
                    ->required(),
//                Forms\Components\FileUpload::make('avatar')
//                    ->directory('avatar')
//                    ->image(),
            ])->columns(2)->columnSpan(2),


        ];

        if(config('filament-user.shield')){
            $rows[] = Forms\Components\Card::make()->schema([
                Forms\Components\MultiSelect::make('roles')
                    ->relationship('roles', 'name')
                    ->label(trans('system::user.resource.roles')),
            ])->columns(1)->columnSpan(1);
        }

        $form->schema($rows)->columns(3);

        return $form;
    }

    public static function table(Table $table): Table
    {
        $table
            ->columns([
                TextColumn::make('id')->sortable()->label(trans('filament-user::user.resource.id')),
//                Tables\Columns\ImageColumn::make('avatar')->rounded(),
                TextColumn::make('name')->sortable()->searchable()->label(trans('filament-user::user.resource.name'))->default(fn($record)=>$record->getFilamentName()),
                TextColumn::make('email')->sortable()->searchable()->label(trans('filament-user::user.resource.email')),
                BooleanColumn::make('email_verified_at')->sortable()->searchable()->label(trans('filament-user::user.resource.email_verified_at')),
                Tables\Columns\TextColumn::make('created_at')->label(trans('filament-user::user.resource.created_at'))
                    ->dateTime('M j, Y')->sortable(),
                Tables\Columns\TextColumn::make('updated_at')->label(trans('filament-user::user.resource.updated_at'))
                    ->dateTime('M j, Y')->sortable(),

            ])
            ->filters([
                Tables\Filters\Filter::make('verified')
                    ->label(trans('filament-user::user.resource.verified'))
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('email_verified_at')),
                Tables\Filters\Filter::make('unverified')
                    ->label(trans('filament-user::user.resource.unverified'))
                    ->query(fn (Builder $query): Builder => $query->whereNull('email_verified_at')),
            ]);

        if(config('filament-user.impersonate')){
            $table->prependActions([
                Impersonate::make('impersonate'),
            ]);
        }

        return $table;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
        ];
    }
}
