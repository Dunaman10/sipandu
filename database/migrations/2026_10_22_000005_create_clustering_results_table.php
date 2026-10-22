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
        Schema::create('clustering_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clustering_session_id')->constrained('clustering_sessions')->cascadeOnDelete();
            $table->foreignId('warga_id')->constrained('wargas')->cascadeOnDelete();
            $table->double('jarak_c1');
            $table->double('jarak_c2');
            $table->double('jarak_c3');
            $table->double('jarak_terdekat');
            $table->enum('cluster_terpilih', ['cluster_1', 'cluster_2', 'cluster_3']);
            $table->string('rekomendasi_kebijakan', 150);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clustering_results');
    }
};
