<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MentionResource\Pages;
use App\Filament\Resources\MentionResource\RelationManagers;
use App\Models\Mention;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MentionResource extends Resource
{
    protected static ?string $model = Mention::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('etudiant_id')
                    ->relationship('etudiant', 'matricule')
                    ->required(),
                Forms\Components\Select::make('ue_id')
                    ->relationship('ue', 'libelle')
                    ->required(),
                Forms\Components\TextInput::make('moyenne')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('mention')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('etudiant.matricule')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ue.code')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('moyenne')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mention')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageMentions::route('/'),
        ];
    }
}
