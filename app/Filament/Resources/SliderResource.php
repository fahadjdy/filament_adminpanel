<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SliderResource\Pages;
use App\Models\Slider;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
// use Filament\Resources\Table;
use Filament\Tables\Table;
use Filament\Resources\Resource;

class SliderResource extends Resource
{
    protected static ?string $model = Slider::class;
    protected static ?string $navigationIcon = 'heroicon-o-camera';
    protected static ?string $navigationGroup = 'Content Management';
    protected static ?string $pluralLabel = 'Sliders';
    protected static ?string $modelLabel = 'Slider';
    protected static ?int $navigationSort = 5;


    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\FileUpload::make('image')
                ->label('Image')
                ->hint('Recommended size ratio: 12:6')
                ->image()
                ->directory('sliders')
                ->required()
                ->maxSize(2048),

            Forms\Components\TextInput::make('title')
                ->required()
                ->maxLength(50)
                ->afterStateUpdated(function (callable $set, $state) {
                    $clean = strip_tags($state);   // removes all HTML tags
                    $set('title', $clean);
                }),

            Forms\Components\Textarea::make('description')
                ->maxLength(150)
                ->afterStateUpdated(function (callable $set, $state) {
                    $clean = strip_tags($state);   // removes all HTML tags
                    $set('description', $clean);
                }),

            Forms\Components\Select::make('status')
                ->options([
                    'Published' => 'Published',
                    'Draft' => 'Draft',
                ])
                ->required()
                ->default('Draft'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')->square(),
                Tables\Columns\TextColumn::make('title')->searchable()->limit(30),
                Tables\Columns\TextColumn::make('description')->limit(50),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => 'Published',
                        'secondary' => 'Draft',
                    ]),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Published' => 'Published',
                        'Draft' => 'Draft',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(), // soft delete
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSliders::route('/'),
            'create' => Pages\CreateSlider::route('/create'),
            'edit' => Pages\EditSlider::route('/{record}/edit'),
        ];
    }
}
