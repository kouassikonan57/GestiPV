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
        Schema::create('mentions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etudiant_id')->constrained('etudiants')->onDelete('cascade');
            $table->foreignId('ue_id')->constrained('ues')->onDelete('cascade');
            $table->double('moyenne');
            $table->enum('mention', ['INSUFFISANT',
                'PASSABLE',
                'ASSEZ BIEN',
                'BIEN',
                'TRES BIEN',
                'EXCELLENT'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mentions');
    }
};
