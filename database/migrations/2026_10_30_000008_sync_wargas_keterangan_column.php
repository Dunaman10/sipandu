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
            if (! Schema::hasColumn('wargas', 'keterangan')) {
                Schema::table('wargas', function (Blueprint $table) {
                    $table->text('keterangan')->nullable()->after('skor_kondisi_rumah');
                });

                if (Schema::hasColumn('wargas', 'catatan_bendahara')) {
                    DB::table('wargas')
                        ->whereNull('keterangan')
                        ->whereNotNull('catatan_bendahara')
                        ->update(['keterangan' => DB::raw('catatan_bendahara')]);
                }
            }

            Schema::table('wargas', function (Blueprint $table) {
                if (Schema::hasColumn('wargas', 'status_iuran')) {
                    $table->dropColumn('status_iuran');
                }
                if (Schema::hasColumn('wargas', 'catatan_bendahara')) {
                    $table->dropColumn('catatan_bendahara');
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

