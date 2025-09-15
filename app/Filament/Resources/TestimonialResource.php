<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Models\Testimonial;
use Filament\Forms;
use Filament\Forms\Form as FormsForm;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table as TablesTable;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';
    protected static ?string $navigationLabel = 'Testimonials';
    protected static ?string $pluralLabel = 'Testimonials';
    protected static ?string $modelLabel = 'Testimonial';
    protected static ?string $navigationGroup = 'Content Management';
    protected static ?int $navigationSort = 3;

    // NOTE: use Filament\Forms\Form (aliased here as FormsForm)
    public static function form(FormsForm $form): FormsForm
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(30)
                ->afterStateUpdated(function (callable $set, $state) {
                    $clean = strip_tags($state);   // removes all HTML tags
                    $set('name', $clean);
                }),

            Forms\Components\TextInput::make('designation')
                ->maxLength(30)
                ->afterStateUpdated(function (callable $set, $state) {
                    $clean = strip_tags($state);   // removes all HTML tags
                    $set('description', $clean);
                }),

            Forms\Components\Textarea::make('content')
                ->required()
                ->maxLength(150)
                ->afterStateUpdated(function (callable $set, $state) {
                    $clean = strip_tags($state);   // removes all HTML tags
                    $set('content', $clean);
                }),

            Forms\Components\FileUpload::make('image')
                ->directory('testimonials')
                ->image()
                ->imageResizeMode('cover')
                ->maxSize(2048),
        ]);
    }

    // NOTE: use Filament\Tables\Table (aliased here as TablesTable)
    public static function table(TablesTable $table): TablesTable
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('designation')->sortable(),
                Tables\Columns\TextColumn::make('content')->limit(50),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y, H:i'),
                Tables\Columns\TextColumn::make('updated_at')->dateTime('d M Y, H:i'),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit'   => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}
