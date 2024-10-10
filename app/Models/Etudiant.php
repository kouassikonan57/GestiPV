<?php
namespace App\Models;

use App\Models\Scopes\UserScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use Spatie\Permission\Models\Role;

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
            $user = User::create([
                'name' => "{$etudiant->nom} {$etudiant->prenom}",
                'email' => strtolower($etudiant->prenom) . '.' . strtolower($etudiant->nom) . '@ufhb.edu.ci',
                'password' => bcrypt($etudiant->matricule), // Vous pouvez générer un mot de passe plus complexe
            ]);

            $user->assignRole('Etudiant');

            $etudiant->user_id = $user->id;
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
     * Relation avec les UE (Unités d'Enseignement).
     */
    public function ues(): HasMany
    {
        return $this->hasMany(Ue::class);
    }
}
