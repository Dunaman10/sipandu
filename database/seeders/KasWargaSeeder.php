<?php

namespace Database\Seeders;

use App\Models\KasWarga;
use App\Models\User;
use App\Models\Warga;
use Illuminate\Database\Seeder;

class KasWargaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bendahara = User::where('role', 'bendahara')->first() ?? User::first();
        $wargas = Warga::all();

        $periodes = ['2026-09', '2026-10'];

        foreach ($periodes as $periode) {
            foreach ($wargas as $warga) {
                // Determine status based on warga's status_iuran
                $isLunas = ($warga->status_iuran === 'lancar');
                // Give a few random variations for realism
                if ($warga->id % 4 === 0) {
                    $isLunas = false;
                }

                KasWarga::updateOrCreate(
                    [
                        'warga_id' => $warga->id,
                        'periode_bulan' => $periode,
                    ],
                    [
                        'bendahara_id' => $bendahara->id,
                        'nominal_iuran' => 50000,
                        'status_pembayaran' => $isLunas ? 'lunas' : 'belum_lunas',
                        'tanggal_bayar' => $isLunas ? ($periode === '2026-09' ? '2026-09-05' : '2026-10-04') : null,
                        'keterangan' => $isLunas ? 'Pembayaran iuran kas keamanan & kebersihan via Bendahara' : 'Belum membayar iuran kas RT',
                    ]
                );
            }
        }
    }
}
