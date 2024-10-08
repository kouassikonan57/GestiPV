<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EtudiantResource\Pages;
use App\Models\Etudiant;
use App\Models\Parcours;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class EtudiantResource extends Resource
{
    protected static ?string $model = Etudiant::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Étudiants';
    protected static ?string $pluralLabel = 'Étudiants';
    protected static ?string $navigationGroup = 'Administration';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('matricule')
                    ->label("Identifiant Permanent")
                    ->required()
                    ->maxLength(25),
                Forms\Components\TextInput::make('nom')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('prenom')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('date_naissance')
                    ->required(),
                Forms\Components\TextInput::make('lieu_naissance')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('niveau')
                    ->required()
                    ->options([
                        'LICENCE1' => 'Licence 1',
                        'LICENCE2' => 'Licence 2',
                        'LICENCE3' => 'Licence 3',
                        'MASTER1' => 'Master 1',
                        'MASTER2' => 'Master 2',
                    ]),
                Forms\Components\Select::make('parcours_id')
                    ->label('Parcours')
                    ->required()
                    ->relationship('parcours', 'nom'), // Utilise la relation parcours pour afficher le nom
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('matricule')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_naissance')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lieu_naissance')
                    ->searchable(),
                Tables\Columns\TextColumn::make('niveau')
                    ->searchable(),
                Tables\Columns\TextColumn::make('parcours.nom')
                    ->label('Parcours')
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
            'index' => Pages\ManageEtudiants::route('/'),
        ];
    }
}
