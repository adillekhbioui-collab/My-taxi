<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('trajet_id')->constrained('trajets')->cascadeOnDelete();
            $table->enum('statut', ['en_attente', 'confirmee', 'annulee'])->default('confirmee');
            $table->unsignedInteger('position_file')->nullable();
            $table->boolean('paye')->default(false);
            $table->timestamps();

            $table->unique(['user_id', 'trajet_id'], 'uniq_reservation_user_trajet');
            $table->index(['trajet_id', 'statut'], 'idx_reservations_waitlist');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
