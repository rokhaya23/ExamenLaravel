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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->date('date_naissance');
            $table->string('adresse');
            $table->string('telephone');
            $table->string('poste');
            $table->string('sexe');
            $table->string('email');
            $table->string('banque');
            $table->string('numero_compte');
            $table->string('CNI',13);
            $table->string('password');
            $table->string('departement');
            $table->decimal('salaire', 10, 2);
            $table->date('date_embauche');
            $table->json('langues');
            $table->string('situation_matrimonial');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
