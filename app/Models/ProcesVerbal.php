<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProcesVerbal extends Model
{
    use HasFactory;

    protected $table = 'proces_verbals';

    protected $fillable = [
        'etudiant_id',
        'semestre_id',
        'moyenne',
        'decision',
    ];

    /**
     * Relation avec l'étudiant.
     */
    public function etudiant(): BelongsTo
    {
        return $this->belongsTo(Etudiant::class);
    }

    /**
     * Relation avec le semestre.
     */
    public function semestre(): BelongsTo
    {
        return $this->belongsTo(Semestre::class);
    }

    /**
     * Calculer la moyenne globale du semestre pour un étudiant donné.
     *
     * @param int $etudiantId
     * @param int $semestreId
     */
    public static function calculerMoyenneSemestre(int $etudiantId, int $semestreId): void
    {
        $ues = Ue::where('semestre_id', $semestreId)->get();
        $totalCoefficient = 0;
        $totalPondere = 0;

        foreach ($ues as $ue) {
            $mention = Mention::where('etudiant_id', $etudiantId)
                ->where('ue_id', $ue->id)
                ->first();

            if ($mention) {
                $totalPondere += $mention->moyenne * $ue->getTotalCoefficient();
                $totalCoefficient += $ue->getTotalCoefficient();
            }
        }

        if ($totalCoefficient > 0) {
            $moyenne = round($totalPondere / $totalCoefficient, 2);
            $decision = $moyenne >= 10 ? 'ADMIS' : 'AJOURNE';

            self::updateOrCreate(
                [
                    'etudiant_id' => $etudiantId,
                    'semestre_id' => $semestreId,
                ],
                [
                    'moyenne' => $moyenne,
                    'decision' => $decision,
                ]
            );
        }
    }
}
