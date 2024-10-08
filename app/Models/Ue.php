<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Ue extends Model
{
    use HasFactory;

    protected $table = 'ues';

    protected $fillable = [
        'code',
        'libelle',
        'type',
        'semestre_id',
    ];

    public function ecues(): HasMany
    {
        return $this->hasMany(Ecue::class);
    }

    /**
     * Relation avec le semestre.
     */
    public function semestre(): BelongsTo
    {
        return $this->belongsTo(Semestre::class);
    }

    /**
     * Calculer la moyenne de l'UE pour un étudiant donné et enregistrer la décision et la mention.
     *
     * @param int $etudiantId
     */
    public function calculerMoyennePourEtudiant(int $etudiantId): void
    {
        $totalCoefficient = 0;
        $totalPondere = 0;
        foreach ($this->ecues as $ecue) {
            $note = $ecue->notes()->where('etudiant_id', $etudiantId)->avg('valeur');

            if ($note !== null) {
                $totalPondere += $note * $ecue->coefficient;
                $totalCoefficient += $ecue->coefficient;
            }
        }

        if ($totalCoefficient > 0) {
            $moyenne = round($totalPondere / $totalCoefficient, 2);

            // Déterminer la mention en fonction de la moyenne
            $mention = $this->determinerMention($moyenne);

            // Créer ou mettre à jour la décision
            mention::updateOrCreate(
                [
                    'etudiant_id' => $etudiantId,
                    'ue_id' => $this->id,
                ],
                [
                    'moyenne' => $moyenne,
                    'mention' => $mention,
                ]
            );
        }
    }

    /**
     * Déterminer la mention en fonction de la moyenne.
     *
     * @param float $moyenne
     * @return string
     */
    protected function determinerMention(float $moyenne): string
    {
        if ($moyenne < 10) {
            return 'INSUFFISANT';
        } elseif ($moyenne < 12) {
            return 'PASSABLE';
        } elseif ($moyenne < 14) {
            return 'ASSEZ BIEN';
        } elseif ($moyenne < 16) {
            return 'BIEN';
        } elseif ($moyenne < 18) {
            return 'TRES BIEN';
        } else {
            return 'EXCELLENT';
        }
    }

    /**
     * Calculer la somme des coefficients des ECUEs.
     *
     * @return int
     */
    public function getTotalCoefficient(): int
    {
        return $this->ecues->sum('coefficient');
    }


    /**
     * Relation avec la mention de l'UE.
     */
    public function mention(): HasOne
    {
        return $this->hasOne(Mention::class);
    }


}
