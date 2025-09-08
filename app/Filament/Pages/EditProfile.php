<?php
namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;


class EditProfile extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationLabel = 'My Profile';
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $slug = 'my-profile';

    public $name;
    public $email;
    public $contact;
    public $city;
    public $state;
    public $location;
    public $pincode;
    public $about;
    public $slogan;
    public $company_image;
    public $logo;
    public $favicon;
    public $latitude;
    public $longitude;

    public function mount(): void
    {
        $profile = Auth::user()->companyProfile;

        if ($profile) {
            $this->fill($profile->toArray());
        }
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('name')->required(),
            Forms\Components\TextInput::make('email')->email(),
            Forms\Components\TextInput::make('contact')->maxLength(20),

            Forms\Components\TextInput::make('city'),
            Forms\Components\TextInput::make('state'),
            Forms\Components\TextInput::make('location'),
            Forms\Components\TextInput::make('pincode'),

            Forms\Components\Textarea::make('about'),
            Forms\Components\TextInput::make('slogan'),

            Forms\Components\FileUpload::make('company_image')->directory('company')->image()->maxSize(2048),
            Forms\Components\FileUpload::make('logo')->directory('company')->image()->maxSize(1024),
            Forms\Components\FileUpload::make('favicon')->directory('company')->image()->maxSize(512),

            Forms\Components\TextInput::make('latitude')->numeric(),
            Forms\Components\TextInput::make('longitude')->numeric(),
        ];
    }

    public function save(): void
    {
        $profile = Auth::user()->companyProfile;

        if ($profile) {
            $profile->update($this->form->getState());
        } else {
            Auth::user()->companyProfile()->create($this->form->getState());
        }

       Notification::make()
        ->title('Profile updated successfully!')
        ->success()
        ->send();
    }

    protected static string $view = 'filament.pages.edit-profile';
}
