<?php

namespace Modules\System\Admin\Pages;

use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use JeffGreco13\FilamentBreezy\FilamentBreezy;
use JeffGreco13\FilamentBreezy\Http\Livewire\Auth\Register as BreezyRegister;

class Register extends BreezyRegister
{
    public $name;
    public $last_name;
    public $phone_number;

    public $password;
    public $password_confirm;
    protected function getFormSchema(): array
    {
        return [
            TextInput::make('name')
                ->label(trans('system::users.name'))
                ->required(),
            TextInput::make('last_name')
                ->label(trans('system::users.last_name')),
            TextInput::make('phone_number')
                ->label(trans('system::users.phone_number'))
                ->rule('digits_between:9,10')
                ->unique('users','phone_number',fn($record)=>$record)
                ->required(),
            TextInput::make('password')
                ->label(trans('system::users.password'))
                ->rules(app(FilamentBreezy::class)->getPasswordRules())
                ->password()
                ->required(),
            TextInput::make('password_confirm')
                ->label(trans('system::users.password_confirmation'))
                ->same('password_confirm')
                ->password()
                ->required(),
        ];
    }

    protected function prepareModelData($data): array
    {
        $preparedData = [
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'phone_number' => $data['phone_number'],
            'password' => Hash::make($data['password']),
        ];

        return $preparedData;
    }

    public function register()
    {
        $preparedData = $this->prepareModelData($this->form->getState());

        $user = config('filament-breezy.user_model')::create($preparedData);

        event(new Registered($user));
        Filament::auth()->login($user, true);

        return redirect()->to(config('filament-breezy.registration_redirect_url'));
    }
}
