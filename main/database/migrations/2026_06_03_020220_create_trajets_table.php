<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trajets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('courtier_id')->constrained('users')->cascadeOnDelete();
            $table->string('ville_depart', 80);
            $table->string('ville_arrivee', 80);
            $table->dateTime('heure_depart');
            $table->decimal('prix', 8, 2);
            $table->unsignedTinyInteger('places_total');
            $table->unsignedTinyInteger('places_disponibles');
            $table->string('chauffeur_nom', 100);
            $table->string('chauffeur_tel', 20);
            $table->enum('statut', ['planifie', 'en_cours', 'termine', 'annule'])->default('planifie');
            $table->timestamps();

            $table->index(['ville_depart', 'ville_arrivee', 'heure_depart'], 'idx_trajets_recherche');
            $table->index(['statut', 'heure_depart'], 'idx_trajets_24h');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trajets');
    }
};
