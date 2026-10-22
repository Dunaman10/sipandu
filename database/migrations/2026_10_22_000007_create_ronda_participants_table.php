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
        Schema::create('ronda_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ronda_schedule_id')->constrained('ronda_schedules')->cascadeOnDelete();
            $table->foreignId('warga_id')->constrained('wargas')->cascadeOnDelete();
            $table->enum('status_kehadiran', ['hadir', 'izin', 'alpha', 'digantikan'])->default('alpha');
            $table->text('catatan_keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ronda_participants');
    }
};
