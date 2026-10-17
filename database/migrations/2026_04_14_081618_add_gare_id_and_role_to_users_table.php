<?php

use App\Models\Gare;
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
        Schema::table('users', function (Blueprint $table) {
            // Clé étrangère gare
            $table->foreignIdFor(Gare::class, 'gare_id')
                  ->nullable()
                  ->constrained('gares')
                  ->onDelete('set null')
                  ->after('email');
            
            // Rôle avec enum ou string
            $table->enum('role', ['admin', 'agent', 'superviseur', 'utilisateur'])
                  ->default('user')
                  ->after('gare_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['gare_id']);
            $table->dropColumn(['gare_id', 'role']);
        });
    }
};
