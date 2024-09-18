<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Étudiants';
    protected static ?string $pluralLabel = 'Étudiants';
    protected static ?string $navigationGroup = 'Administration';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Informations de l\'étudiant')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Informations personnelles')
                            ->schema([
                                Forms\Components\TextInput::make('last_name')
                                    ->label('Nom de famille')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('first_name')
                                    ->label('Prénom')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('permanent_id')
                                    ->label('Identifiant permanent')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\DatePicker::make('birth_date')
                                    ->label('Date de naissance')
                                    ->required(),
                                Forms\Components\TextInput::make('birth_place')
                                    ->label('Lieu de naissance')
                                    ->required()
                                    ->maxLength(255),
                            ]),

                        Forms\Components\Tabs\Tab::make('Informations académiques')
                            ->schema([
                                Forms\Components\TextInput::make('level')
                                    ->label('Niveau')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('specialization')
                                    ->label('Spécialisation')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('academic_year')
                                    ->label('Année académique')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('degree_pursued')
                                    ->label('Diplôme préparé')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('last_name')
                    ->label('Nom de famille')
                    ->searchable(),
                Tables\Columns\TextColumn::make('first_name')
                    ->label('Prénom')
                    ->searchable(),
                Tables\Columns\TextColumn::make('permanent_id')
                    ->label('Identifiant permanent')
                    ->searchable(),
                Tables\Columns\TextColumn::make('birth_date')
                    ->label('Date de naissance')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('birth_place')
                    ->label('Lieu de naissance')
                    ->searchable(),
                Tables\Columns\TextColumn::make('level')
                    ->label('Niveau')
                    ->searchable(),
                Tables\Columns\TextColumn::make('specialization')
                    ->label('Spécialisation')
                    ->searchable(),
                Tables\Columns\TextColumn::make('academic_year')
                    ->label('Année académique')
                    ->searchable(),
                Tables\Columns\TextColumn::make('degree_pursued')
                    ->label('Diplôme préparé')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Mis à jour le')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->modalWidth(MaxWidth::FitContent),
                Tables\Actions\EditAction::make()->modalWidth(MaxWidth::FitContent),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageStudents::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
