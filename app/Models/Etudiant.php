<?php
namespace App\Models;

use App\Models\Scopes\UserScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Etudiant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'matricule',
        'nom',
        'prenom',
        'date_naissance',
        'lieu_naissance',
        'niveau',
        'parcours_id',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new UserScope());

        static::creating(function ($etudiant) {
            if (!$etudiant->user_id) {
                $user = DB::transaction(function () use ($etudiant) {
                    $user = User::create([
                        'name' => "{$etudiant->nom} {$etudiant->prenom}",
                        'email' => strtolower(last(explode(' ', trim($etudiant->prenom)))) . '.' . strtolower($etudiant->nom) . '@ufhb.edu.ci',
                        'password' => bcrypt($etudiant->matricule),
                    ]);

                    $user->assignRole('Etudiant');

                    return $user;
                });

                $user = $user->fresh();
                $etudiant->user_id = $user->id;
            }
        });
    }


    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function parcours(): BelongsTo
    {
        return $this->belongsTo(Parcours::class);
    }

    public function procesVerbals(): HasMany
    {
        return $this->hasMany(ProcesVerbal::class);
    }

    /**
     * Relation avec les UE (Unités d’Enseignement).
     */
    public function ues(): HasMany
    {
        return $this->hasMany(Ue::class);
    }
}
