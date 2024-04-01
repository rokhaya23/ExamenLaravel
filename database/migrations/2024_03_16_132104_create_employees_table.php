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
            $table->date('date_naissance')->nullable();
            $table->string('adresse')->nullable();
            $table->string('telephone')->nullable();
            $table->string('poste')->nullable();
            $table->string('sexe')->nullable();
            $table->string('email');
            $table->string('banque')->nullable();
            $table->string('numero_compte')->nullable();
            $table->string('CNI',13)->nullable();
            $table->string('password')->nullable();
            $table->string('departement')->nullable();
            $table->decimal('salaire', 10, 2)->nullable();
            $table->date('date_embauche')->nullable();
            $table->json('langues')->nullable();
            $table->string('situation_matrimonial')->nullable();
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
