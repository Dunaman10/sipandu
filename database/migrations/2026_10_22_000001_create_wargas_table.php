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
        Schema::create('wargas', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->unique();
            $table->string('no_kk', 16);
            $table->string('nama_lengkap', 150);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tanggal_lahir');
            $table->string('alamat_blok', 255);
            $table->enum('status_ktp', ['ada', 'belum'])->default('ada');
            $table->string('pekerjaan', 100);
            $table->integer('usia');
            $table->decimal('penghasilan_bulanan', 12, 2)->default(0);
            $table->integer('skor_ekonomi')->default(1);
            $table->integer('jumlah_tanggungan')->default(0);
            $table->enum('status_kepemilikan_rumah', ['milik_sendiri', 'sewa_kontrak', 'menumpang'])->default('milik_sendiri');
            $table->enum('kondisi_rumah', ['layak_huni', 'kurang_layak', 'tidak_layak'])->default('layak_huni');
            $table->integer('skor_kondisi_rumah')->default(1);
            $table->text('keterangan')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wargas');
    }
};
