<?php
namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Content Management';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
           Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(50)
                ->hint('The category name, Max 50 characters')
                ->live(onBlur: true) // auto update slug when leaving field
                ->afterStateUpdated(function (callable $set, $state) {
                    $clean = strip_tags($state);   // removes all HTML tags
                    $set('name', $clean);
                    $set('slug', \Str::slug($clean));
                }),

            Forms\Components\TextInput::make('slug')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(255),

            Forms\Components\Textarea::make('content')
            ->afterStateUpdated(function (callable $set, $state) {
                $clean = strip_tags($state);   // removes all HTML tags
                $set('content', $clean);
            }),

            Forms\Components\Select::make('parent_id')
                ->label('Parent Category')
                ->relationship('parent', 'name')
                ->searchable()
                ->nullable(),

            Forms\Components\FileUpload::make('images')
                ->label('Images')
                ->directory('categories')
                ->multiple()
                ->image()
                ->reorderable()
                ->maxFiles(5)
                ->maxSize(2048),

            Forms\Components\Select::make('primary_image')
                ->label('Primary Image')
                ->options(function (callable $get) {
                    $images = $get('images');

                    if (!is_array($images)) {
                        return [];
                    }

                    return collect($images)
                        ->filter(fn($img) => is_string($img)) // keep only strings
                        ->mapWithKeys(fn($img) => [$img => basename($img)]);
                })
                ->nullable()
                ->helperText('Choose one image as the primary image.')

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('parent.name')->label('Parent'),
            Tables\Columns\TextColumn::make('slug')->sortable()->searchable(),
            Tables\Columns\ImageColumn::make('primary_image')->label('Primary'),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
