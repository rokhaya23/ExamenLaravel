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
        Schema::create('categorie_conges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idType_conge');
            $table->string('paiement');
            $table->integer('jours_autorise');
            $table->integer('jours_utiliser');
            $table->integer('jours_restant');
            $table->timestamps();

            $table->foreign('idType_conge')->references('id')->on('gestion_conges')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorie_conges');
    }
};
