<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Category;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use FilamentTiptapEditor\TiptapEditor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make("name")
                    ->label("Название")
                    ->columnSpanFull()
                    ->required(),
                Forms\Components\TextInput::make("description")
                    ->label("Описание")
                    ->columnSpanFull()
                    ->required(),
                Forms\Components\DatePicker::make("created_at")
                    ->label('Дата')
                    ->default('2025-01-01') // Фиксированная дата
                    ->columnSpan(1)
                    ->required(),
                Select::make('category_id')
                    ->label('Категория')
                    ->relationship('category', 'name')
                    ->required(),
                FileUpload::make('image') // Используем поле file_name для хранения имени файла
                ->label('Картинка')
                    ->columnSpan(1)
                    ->directory('product_imgs') // Каталог хранения
                    ->image() // Определяет, что это изображение
                    /*->getUploadedFileNameForStorageUsing(function ($file) {
                        // Генерируем случайное имя файла
                        return Str::random(10) . '.' . $file->getClientOriginalExtension();
                    })*/
                    ->rules(['dimensions:width=479,height=340'])
                    ->validationMessages([
                        'dimensions' => 'Изображение должно быть строго 479x340 пикселей!',
                    ])
                    ->preserveFilenames(false) // Не сохраняем оригинальное имя
                    ->required()
                    ->enableDownload() // Добавляем возможность скачивания
                    ->disk('public'),
            ]);
    }

    public static function editForm(Form $form): Form
    {
        return $form->schema([
            FileUpload::make('image')
                ->label('Картинка')
                ->directory('product_imgs')
                ->image()
                /*->getUploadedFileNameForStorageUsing(function ($file) {
                    // Генерируем новое случайное имя файла
                    return Str::random(10) . '.' . $file->getClientOriginalExtension();
                })*/
                ->preserveFilenames(false) // Не сохраняем оригинальное имя
                ->imagePreview() // Показывает превью загруженной картинки
                ->disk('public') // Убедись, что используешь правильный диск
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("id")->sortable(),
                TextColumn::make("created_at")->dateTime('d.m.Y'),
                TextColumn::make("name")
                    ->limit(50)
                    ->searchable(),
                ImageColumn::make('image') // Колонка с изображением
                    ->disk('public') // Укажите диск, если изображения хранятся на каком-то диске
                    ->width(50), // Высота изображения
                TextColumn::make('category.name')
                    ->label('Категория')
                    ->sortable()
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('category')
                    ->label('Категория')
                    ->relationship('category', 'name') // Если есть связь с моделью Category
                    ->options(fn () => Category::pluck('name', 'id')->toArray())
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
                DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
