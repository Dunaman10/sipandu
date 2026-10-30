<?php

namespace Database\Seeders;

use App\Models\RondaParticipant;
use App\Models\RondaSchedule;
use App\Models\User;
use App\Models\Warga;
use Illuminate\Database\Seeder;

class RondaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ketuaRt = User::where('role', 'ketua_rt')->first() ?? User::first();
        // Ambil data warga laki-laki dewasa yang ditugaskan ronda
        $maleWargas = Warga::where('jenis_kelamin', 'L')->get();

        if ($maleWargas->count() < 4) {
            $maleWargas = Warga::all();
        }

        $schedules = [
            [
                'tanggal_ronda' => '2026-10-20',
                'shift_ronda' => 'Malam (22:00 - 04:00)',
                'keterangan_khusus' => 'Patroli rutin pos ronda gerbang utama dan gang buntu',
                'participants' => [
                    ['warga_idx' => 0, 'catatan' => 'Regu A - Koordinator pos portal'],
                    ['warga_idx' => 1, 'catatan' => 'Regu A - Patroli blok A'],
                    ['warga_idx' => 2, 'catatan' => 'Regu A - Standby pos ronda'],
                    ['warga_idx' => 3, 'catatan' => 'Regu A - Patroli blok B'],
                ],
            ],
            [
                'tanggal_ronda' => '2026-10-21',
                'shift_ronda' => 'Malam (22:00 - 04:00)',
                'keterangan_khusus' => 'Pemeriksaan tamu malam dan penutupan portal jam 23.00',
                'participants' => [
                    ['warga_idx' => 4, 'catatan' => 'Regu B - Koordinator'],
                    ['warga_idx' => 5, 'catatan' => 'Regu B - Patroli blok C'],
                    ['warga_idx' => 6, 'catatan' => 'Regu B - Standby pos ronda'],
                    ['warga_idx' => 7, 'catatan' => 'Regu B - Patroli blok D'],
                ],
            ],
            [
                'tanggal_ronda' => '2026-10-22',
                'shift_ronda' => 'Malam (22:00 - 04:00)',
                'keterangan_khusus' => 'Jadwal Ronda Malam Ini - Siaga keamanan lingkungan RT 03',
                'participants' => [
                    ['warga_idx' => 8, 'catatan' => 'Regu C - Koordinator'],
                    ['warga_idx' => 9, 'catatan' => 'Regu C - Patroli blok A & B'],
                    ['warga_idx' => 10, 'catatan' => 'Regu C - Standby pos ronda'],
                    ['warga_idx' => 11, 'catatan' => 'Regu C - Patroli blok C & D'],
                ],
            ],
            [
                'tanggal_ronda' => '2026-10-23',
                'shift_ronda' => 'Malam (22:00 - 04:00)',
                'keterangan_khusus' => 'Jadwal Ronda Besok Malam - Waspada cuaca hujan',
                'participants' => [
                    ['warga_idx' => 12, 'catatan' => 'Regu D - Koordinator'],
                    ['warga_idx' => 13, 'catatan' => 'Regu D - Patroli'],
                    ['warga_idx' => 14, 'catatan' => 'Regu D - Standby pos ronda'],
                    ['warga_idx' => 15, 'catatan' => 'Regu D - Patroli'],
                ],
            ],
        ];

        foreach ($schedules as $schedData) {
            $schedule = RondaSchedule::updateOrCreate(
                [
                    'tanggal_ronda' => $schedData['tanggal_ronda'],
                ],
                [
                    'shift_ronda' => $schedData['shift_ronda'],
                    'keterangan_khusus' => $schedData['keterangan_khusus'],
                    'created_by' => $ketuaRt->id,
                ]
            );

            foreach ($schedData['participants'] as $p) {
                if (isset($maleWargas[$p['warga_idx']])) {
                    $warga = $maleWargas[$p['warga_idx']];
                    RondaParticipant::updateOrCreate(
                        [
                            'ronda_schedule_id' => $schedule->id,
                            'warga_id' => $warga->id,
                        ],
                        [
                            'catatan_keterangan' => $p['catatan'],
                        ]
                    );
                }
            }
        }
    }
}
