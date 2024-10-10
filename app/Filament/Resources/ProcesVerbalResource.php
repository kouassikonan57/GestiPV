<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProcesVerbalResource\Pages;
use App\Filament\Resources\ProcesVerbalResource\RelationManagers;
use App\Models\Etudiant;
use App\Models\ProcesVerbal;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProcesVerbalResource extends Resource
{
    protected static ?string $model = ProcesVerbal::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Gestion';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('etudiant.matricule')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('semestre.libelle')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('moyenne')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('decision')
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
                Tables\Actions\Action::make('generatePdf')
                    ->label('Générer Procès-Verbal')
                    ->action(fn($record) => static::generatePdf($record->etudiant_id))
                    ->requiresConfirmation()
                    ->icon('heroicon-o-arrow-down-tray'),
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
            'index' => Pages\ManageProcesVerbals::route('/'),
        ];
    }

    protected static function generatePdf($etudiantId): StreamedResponse
    {
        // Charger les informations de l'étudiant avec ses semestres et unités d'enseignement
        $etudiant = Etudiant::with(['procesVerbals.semestre.ues'])->findOrFail($etudiantId);

        // Calculer le total des crédits obtenus
        $totalCredits = $etudiant->procesVerbals->sum(function ($pv) {
            return $pv->semestre->ues->sum(function ($ue) {
                return $ue->getTotalCoefficient();
            });
        });

        // Récupérer les informations des semestres, moyennes et décisions
        $decisionSemestres = $etudiant->procesVerbals->map(function ($procesVerbal) {
            return [
                'semestre' => $procesVerbal->semestre,
                'moyenne' => $procesVerbal->moyenne,
                'decision' => $procesVerbal->decision,
            ];
        });

        // Déterminer la décision annuelle
        if ($totalCredits == 60) {
            $decisionAnnuelle = 'ADMIS';
        } elseif ($totalCredits >= 48) {
            $decisionAnnuelle = 'REPECHE';
        } else {
            $decisionAnnuelle = 'AJOURNE';
        }

        // Créer les données à envoyer à la vue
        $data = [
            'etudiant' => $etudiant,
            'decisionSemestres' => $decisionSemestres,
            'totalCredits' => $totalCredits,
            'decisionAnnuelle' => $decisionAnnuelle,
        ];

        // Générer le PDF
        $pdf = Pdf::loadView('proces-verbal-template', $data);

        // Télécharger le fichier PDF
        return response()->streamDownload(fn() => print($pdf->output()), 'proces_verbal.pdf', [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="proces_verbal.pdf"',
        ]);
    }

}
