<?php

use App\Models\TypeColis;
use App\Models\User;
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
        Schema::create('colis', function (Blueprint $table) {
            $table->id();
            $table->string('numero_année', length: 100)->unique();
            $table->string('numero_journée', length: 100)->unique();
            $table->foreignIdFor(TypeColis::class)->constrained()->onDelete('cascade');
            $table->string('unite', length: 100);
            $table->integer('quantite');
            $table->integer('montant');
            $table->string('nom_envoyeur', length: 100);
            $table->string('numero_envoyeur', length: 100);
            $table->string('nom_destinataire', length: 100);
            $table->string('numero_destinataire', length: 100);
            $table->string('gare_envois', length: 100);
            $table->string('gare_destination', length: 100);
            $table->string('code_recuperation', length: 100);
            $table->string('status_envois', length: 100);
            $table->foreignIdFor(User::class)->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colis');
    }
};
