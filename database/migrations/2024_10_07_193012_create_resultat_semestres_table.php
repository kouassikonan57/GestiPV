<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('resultat_semestres', function (Blueprint $table) {
            $table->id('id')->primary();
            $table->id('etudiant_id');
            $table->id('semestre_id');
            $table->enum('decision', ['ADMIS', 'AJOURNE', 'REFUSE']);
            $table->timestamps();

            // Relations
            $table->foreign('etudiant_id')->references('id')->on('etudiants')->onDelete('cascade');
            $table->foreign('semestre_id')->references('id')->on('semestres')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resultat_semestres');
    }
};
