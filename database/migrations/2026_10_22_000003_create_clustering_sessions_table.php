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
        Schema::create('clustering_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('kode_sesi', 30)->unique();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->dateTime('tanggal_proses');
            $table->integer('jumlah_cluster')->default(3);
            $table->integer('total_data_warga');
            $table->integer('total_iterasi')->default(1);
            $table->json('centroid_awal_json');
            $table->json('centroid_akhir_json');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clustering_sessions');
    }
};
