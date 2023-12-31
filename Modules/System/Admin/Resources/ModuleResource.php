<?php

namespace Modules\System\Admin\Resources;

use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Support\Facades\Artisan;
use Modules\System\Admin\Resources\ModuleResource\Pages;
use Modules\System\Admin\Resources\ModuleResource\RelationManagers;
use Modules\System\Models\Module;

class ModuleResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Module::class;

    protected static $permissionsCollection;
    protected static ?string $navigationIcon = 'heroicon-o-view-grid';

    protected static function getNavigationGroup(): ?string
    {
        return config('system.groups.system');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('description')->searchable(),
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('version'),
                Tables\Columns\BooleanColumn::make('enabled'),
                Tables\Columns\BooleanColumn::make('installed'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('disable')
                    ->action(function ($record){
                        $module = \Module::find($record->name);
                        $module->disable();
                    })
                    ->requiresConfirmation()
                    ->color('danger')
                    ->iconButton()
                    ->icon('heroicon-o-ban')
                    ->size('lg')
                    ->successNotificationMessage('Module has been disabled!')
                    ->visible(fn($record)=>$record->enabled && $record->type=='module' && $record->installed && auth()->user()->can('manage_system')),
                Tables\Actions\Action::make('enable')
                    ->color('success')
                    ->action(function ($record){
                        $module = \Module::find($record->name);
                        $module->enable();
                    })
                    ->requiresConfirmation()
                    ->iconButton()
                    ->icon('heroicon-o-check')
                    ->size('lg')
                    ->visible(fn($record)=>!$record->enabled && $record->installed && $record->type=='module' && auth()->user()->can('manage_system')),
                Tables\Actions\Action::make('install')
                    ->color('success')
                    ->action(function ($record){
                        try {
                            $module = \Module::find($record->name);
                            $module->enable();
                            Artisan::call('optimize:clear');
                            app()->register('Modules\\'.$module->getName()."\\Providers\\InstallerServiceProvider");
                            $module->json()->set('installed',true)->save();
                        }catch (\Exception $exception){
                            $module->disable();
                            logger($exception->getMessage());
                        }

                    })
                    ->requiresConfirmation()
                    ->iconButton()
                    ->icon('heroicon-o-download')
                    ->size('lg')
                    ->visible(fn($record)=>!$record->installed && $record->type=='module' && auth()->user()->can('manage_system')),
                Tables\Actions\Action::make('uninstall')
                    ->color('danger')
                    ->action(function ($record){
                        try {
                            $module = \Module::find($record->name);
                            app()->register('Modules\\'.$module->getName()."\\Providers\\UninstallerServiceProvider");
                            $module->json()->set('installed',false)->save();
                        }catch (\Exception $exception){
                            logger($exception->getMessage());
                        }

                    })
                    ->requiresConfirmation()
                    ->iconButton()
                    ->icon('heroicon-o-trash')
                    ->size('lg')
                    ->visible(fn($record)=>$record->installed && !$record->enabled && $record->type=='module' && auth()->user()->can('manage_system')),
            ])
            ->bulkActions([
                //Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageModules::route('/'),
        ];
    }

    public static function getPermissionPrefixes(): array
    {
        return [
            'view_any',
        ];
    }
}
