<?php
namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationGroup = 'Content Management';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('category_id')
                ->relationship('category', 'name')
                ->required()
                ->searchable()
                ->preload(),

            Forms\Components\TextInput::make('name')
                ->required()
                ->hint('The product name, Max 50 characters')
                ->maxLength(50)
                ->live(onBlur: true)
                ->afterStateUpdated(function (callable $set, $state) {
                    $clean = strip_tags($state);   // removes all HTML tags
                    $set('name', $clean);
                    $set('slug', \Str::slug($clean));
                }),

            Forms\Components\TextInput::make('slug')
                ->required()
                ->readOnly()
                ->unique(ignoreRecord: true),

                // product code 
            Forms\Components\TextInput::make('code')
                ->required()
                ->hint('The product code, Max 10 characters')
                ->maxLength(10)
                ->placeholder('Ex: ABC001')
                ->live(onBlur: true)
                ->afterStateUpdated(function (callable $set, $state) {
                    $clean = strip_tags($state);   // removes all HTML tags
                    $set('code', $clean);
                }),

            Forms\Components\RichEditor::make('description')
                ->label('Description')
                ->toolbarButtons([
                    'bold',
                    'italic',
                    'strike',
                    'link',
                    'orderedList',
                    'bulletList',
                    'blockquote',
                    'codeBlock',
                    'h2',
                    'h3',
                ])
                ->columnSpanFull()
                ->maxLength(5000),


            Forms\Components\FileUpload::make('images')
                ->label('Product Images')
                ->directory('products')
                ->multiple()
                ->image()
                ->reorderable()
                ->maxFiles(6)
                ->maxSize(2048),

            Forms\Components\Select::make('primary_image')
                ->label('Primary Image')
                ->options(function (callable $get) {
                    $images = $get('images');
                    if (!is_array($images)) {
                        return [];
                    }
                    return collect($images)
                        ->filter(fn ($img) => is_string($img))
                        ->mapWithKeys(fn ($img) => [$img => basename($img)]);
                })
                ->nullable()
                ->helperText('Choose one image as the primary image.'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('slug')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('code')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('category.name')->label('Category')->sortable(),
                Tables\Columns\ImageColumn::make('primary_image')->label('Primary'),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y'),
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
            'index'  => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit'   => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
