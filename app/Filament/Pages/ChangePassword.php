<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ChangePassword extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationLabel = 'Change Password';
    protected static ?string $navigationIcon = 'heroicon-o-lock-closed';
    protected static ?string $slug = 'change-password';

    protected static string $view = 'filament.pages.change-password';
    protected static ?int $navigationSort = 2;


    public $new_password;

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('new_password')
                ->label('New Password')
                ->password()
                ->required()
                ->minLength(6),
        ];
    }

    public function submit()
    {
        $data = $this->form->getState();
        $user = Auth::user();

        $user->password = Hash::make($data['new_password']);
        $user->save();

        $this->form->fill([]); // reset form
    }
     
}
