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
        Schema::create('clustering_iterations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clustering_session_id')->constrained('clustering_sessions')->cascadeOnDelete();
            $table->integer('iterasi_ke');
            $table->json('centroid_iterasi_json');
            $table->json('matriks_jarak_json');
            $table->boolean('is_konvergen')->default(false);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clustering_iterations');
    }
};
