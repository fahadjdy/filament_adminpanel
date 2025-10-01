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
                ->live(onBlur: true)
                ->afterStateUpdated(function (callable $set, $state) {
                    $clean = strip_tags($state);
                    $set('name', $clean);
                    $set('slug', \Str::slug($clean));
                }),

            Forms\Components\TextInput::make('slug')
                ->required()
                ->readOnly()
                ->unique(ignoreRecord: true)
                ->maxLength(255),

            Forms\Components\Textarea::make('content')
                ->afterStateUpdated(function (callable $set, $state) {
                    $clean = strip_tags($state);
                    $set('content', $clean);
                }),

            Forms\Components\TextInput::make('meta_title')
                ->maxLength(70)
                ->label('Meta Title'),

            Forms\Components\Textarea::make('meta_description')
                ->maxLength(160)
                ->label('Meta Description'),

            Forms\Components\Select::make('parent_id')
                ->label('Parent Category')
                ->relationship('parent', 'name')
                ->searchable()
                ->preload()
                ->nullable(),

            // Single image upload
           Forms\Components\FileUpload::make('image')
                ->label('Category Image')
                ->directory('categories')
                ->image()
                ->disk('public')   // <--- IMPORTANT
                ->maxSize(2048)
                ->helperText('Upload a single image for this category.'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\ImageColumn::make('image')
                ->label('Image')
                ->disk('public')   // <--- same disk as upload
                ->rounded()
                ->height(50)
                ->width(50)
                ->placeholder('N/A'),
            Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('slug')->sortable()->searchable(),
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
