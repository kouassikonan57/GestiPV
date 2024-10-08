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
        Schema::create('proces_verbals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etudiant_id')->constrained('etudiants')->onDelete('cascade');
            $table->foreignId('semestre_id')->constrained('semestres')->onDelete('cascade');
            $table->decimal('moyenne', 5, 2);
            $table->enum('decision', ['ADMIS', 'AJOURNE', 'REFUSE']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proces_verbals');
    }
};
