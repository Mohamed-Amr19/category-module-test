<?php

namespace Modules\Category\Filament\Resources;

use App\Filament\Helpers\FilamentHelpers;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Modules\Category\Filament\Resources\CategoryResource\Pages;
use Modules\Category\Filament\Resources\CategoryResource\RelationManagers;
use Modules\Category\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static ?string $model = \Modules\CategoryModule\Models\Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-bars-4';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()->schema([

                    SpatieMediaLibraryFileUpload::make('image')
                        ->translateLabel()
                        ->collection(fn() => (new self::$model)->getPrimaryMediaCollection())
                        ->avatar()
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/webp'])
                        ->openable()
                        ->downloadable()
                        ->alignCenter()
                        ->columnSpanFull()
                        ->required(),
                    Forms\Components\Select::make('parent_id')
                        ->options(fn()=>Category::query()->get()->pluck('name', 'id')),
                    FilamentHelpers::translateFilamentField(
                        Forms\Components\TextInput::make('name')
                            ->label(__('Name')),
                        ['*']
                    ),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('image')
                    ->translateLabel()
                    ->limit(1)
                    ->circular()
                    ->collection(fn() => (new self::$model)->getPrimaryMediaCollection())
                    ->toggleable(),
                Tables\Columns\TextColumn::make('name')
                    ->translateLabel()
                ,

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}

