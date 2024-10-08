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
        Schema::create('etudiants', function (Blueprint $table) {
            $table->id('id')->primary();
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
            $table->string('nom');
            $table->string('prenom');
            $table->string('matricule')->unique();
            $table->date('date_naissance');
            $table->string('lieu_naissance');
            $table->enum('niveau', ['LICENCE1', 'LICENCE2', 'LICENCE3', 'MASTER1', 'MASTER2']);
            $table->id('parcours_id');
            $table->foreign('parcours_id')->references('id')->on('parcours')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etudiants');
    }
};
