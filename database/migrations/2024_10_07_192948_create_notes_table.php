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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->double('valeur');
            $table->date('date');
            $table->foreignId('etudiant_id')->constrained('etudiants')->onDelete('cascade');
            $table->foreignId('ecue_id')->constrained('ecues')->onDelete('cascade'); // Liaison avec l'ECUE
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
