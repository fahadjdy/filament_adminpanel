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
    protected static ?int $navigationSort = 1;


    // Initialize properties with default values to avoid Livewire null-type issues
    public string $name = '';
    public ?string $email = null;
    public ?string $contact = null;
    public ?string $whatsapp = null;
    public ?string $city = null;
    public ?string $state = null;
    public ?string $location = null;
    public ?string $pincode = null;
    public ?string $about = null;
    public ?string $slogan = null;
    public ?string $latitude = null;
    public ?string $longitude = null;
    public $company_image = null;
    public $logo = null;
    public $favicon = null;


   public function mount(): void
    {
        $profile = Auth::user()->companyProfile;

        if ($profile) {
            $this->form->fill($profile->toArray());
        }
    }

    

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Section::make('Company Info')
                ->schema([
                    Forms\Components\TextInput::make('name')->required(),
                    Forms\Components\TextInput::make('slogan'),
                    Forms\Components\Textarea::make('about')->columnSpanFull(),
                ])
                ->columns(2),

            Forms\Components\Section::make('Contact Info')
                ->schema([
                    Forms\Components\TextInput::make('email')->email(),
                    Forms\Components\TextInput::make('contact')->label('Contact Number')->maxLength(20),
                    Forms\Components\TextInput::make('whatsapp')->label('WhatsApp Number')->maxLength(20),
                    Forms\Components\TextInput::make('city'),
                    Forms\Components\TextInput::make('state'),
                    Forms\Components\TextInput::make('location'),
                    Forms\Components\TextInput::make('pincode'),
                ])
                ->columns(2),

            Forms\Components\Section::make('Branding')
                ->schema([
                   Forms\Components\FileUpload::make('company_image')
                        ->directory('company')
                        ->image()
                        ->maxSize(2048)
                        ->storeFiles()
                        ->preserveFilenames()
                        ->getUploadedFileNameForStorageUsing(fn ($file) => $file->getClientOriginalName()),

                    Forms\Components\FileUpload::make('logo')
                        ->directory('company')
                        ->image()
                        ->maxSize(1024)
                        ->storeFiles()
                        ->preserveFilenames()
                        ->getUploadedFileNameForStorageUsing(fn ($file) => $file->getClientOriginalName()),

                    Forms\Components\FileUpload::make('favicon')
                        ->directory('company')
                        ->image()
                        ->maxSize(512)
                        ->storeFiles()
                        ->preserveFilenames()
                        ->getUploadedFileNameForStorageUsing(fn ($file) => $file->getClientOriginalName()),

                ])
                ->columns(3),

            Forms\Components\Section::make('Map Location')
                ->schema([
                    Forms\Components\TextInput::make('latitude')->numeric(),
                    Forms\Components\TextInput::make('longitude')->numeric(),
                ])
                ->columns(2),
        ];
    }

    public function save(): void
    {
        $profile = Auth::user()->companyProfile;

        $data = $this->form->getState();

        if ($profile) {
            $profile->update($data);
        } else {
            Auth::user()->companyProfile()->create($data);
        }

        Notification::make()
            ->title('Profile updated successfully!')
            ->success()
            ->send();
    }

    protected static string $view = 'filament.pages.edit-profile';
}
