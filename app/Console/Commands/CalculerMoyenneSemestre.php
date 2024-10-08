<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Etudiant;
use App\Models\Semestre;
use App\Models\ProcesVerbal;

class CalculerMoyenneSemestre extends Command
{
    // Nom de la commande (utilisé dans le terminal)
    protected $signature = 'calculer:moyenne-semestre';

    // Description de la commande
    protected $description = 'Calculer la moyenne du semestre pour chaque étudiant.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Récupération de tous les étudiants et semestres
        $etudiants = Etudiant::all();
        $semestres = Semestre::all();

        // Calcul des moyennes pour chaque étudiant et semestre
        foreach ($etudiants as $etudiant) {
            foreach ($semestres as $semestre) {
                ProcesVerbal::calculerMoyenneSemestre($etudiant->id, $semestre->id);
            }
        }

        // Message de confirmation
        $this->info('Calcul des moyennes des semestres terminé avec succès.');
    }
}
