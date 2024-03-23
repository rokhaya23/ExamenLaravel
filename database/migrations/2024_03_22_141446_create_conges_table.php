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
        Schema::create('conges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idEmployee');
            $table->unsignedBigInteger('idType_conge');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->date('nombre_jour');
            $table->string('statut');
            $table->string('telephone');
            $table->timestamps();

            $table->foreign('idType_conge')->references('id')->on('gestion_conges')->onDelete('cascade');
            $table->foreign('idEmployee')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conges');
    }
};
