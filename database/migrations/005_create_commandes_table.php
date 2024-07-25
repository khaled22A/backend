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
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_client');
            // $table->unsignedBigInteger('id_produit');
            $table->string('num_commande');
            $table->dateTime('date_commande');
            $table->string('statut');
            $table->timestamps();
            $table->foreign('id_client')->references('id')->on('clients');
            // $table->foreign('id_produit')->references('id')->on('produits');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};
