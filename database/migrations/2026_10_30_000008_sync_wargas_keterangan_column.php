<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('wargas')) {
            if (! Schema::hasColumn('wargas', 'agama')) {
                Schema::table('wargas', function (Blueprint $table) {
                    $table->enum('agama', ['Islam', 'Kristen Protestan', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'])
                        ->default('Islam')
                        ->after('jenis_kelamin');
                });
            }

            if (! Schema::hasColumn('wargas', 'keterangan')) {
                Schema::table('wargas', function (Blueprint $table) {
                    $table->text('keterangan')->nullable()->after('status_kepemilikan_rumah');
                });

                if (Schema::hasColumn('wargas', 'catatan_bendahara')) {
                    DB::table('wargas')
                        ->whereNull('keterangan')
                        ->whereNotNull('catatan_bendahara')
                        ->update(['keterangan' => DB::raw('catatan_bendahara')]);
                }
            }

            Schema::table('wargas', function (Blueprint $table) {
                $dropCols = [];
                foreach (['jumlah_tanggungan', 'kondisi_rumah', 'skor_kondisi_rumah', 'status_iuran', 'catatan_bendahara'] as $col) {
                    if (Schema::hasColumn('wargas', $col)) {
                        $dropCols[] = $col;
                    }
                }
                if (! empty($dropCols)) {
                    $table->dropColumn($dropCols);
                }
            });
        }

        if (Schema::hasTable('ronda_participants') && Schema::hasColumn('ronda_participants', 'status_kehadiran')) {
            Schema::table('ronda_participants', function (Blueprint $table) {
                $table->dropColumn('status_kehadiran');
            });
        }

        Schema::dropIfExists('kas_wargas');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema alignment migration
    }
};
