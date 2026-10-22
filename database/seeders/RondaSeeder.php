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
        // Get male citizens (usually participating in night patrols)
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
                    ['warga_idx' => 0, 'status' => 'hadir', 'catatan' => 'Standby dari jam 22.00 sampai selesai'],
                    ['warga_idx' => 1, 'status' => 'hadir', 'catatan' => 'Membawa senter patroli lingkungan'],
                    ['warga_idx' => 2, 'status' => 'izin', 'catatan' => 'Sakit demam, surat terlampir via WA'],
                    ['warga_idx' => 3, 'status' => 'digantikan', 'catatan' => 'Digantikan oleh saudara sepupu'],
                ],
            ],
            [
                'tanggal_ronda' => '2026-10-21',
                'shift_ronda' => 'Malam (22:00 - 04:00)',
                'keterangan_khusus' => 'Pemeriksaan tamu malam dan portal lingkungan RT',
                'participants' => [
                    ['warga_idx' => 4, 'status' => 'hadir', 'catatan' => 'Tepat waktu'],
                    ['warga_idx' => 5, 'status' => 'alpha', 'catatan' => 'Tidak hadir tanpa pemberitahuan'],
                    ['warga_idx' => 6, 'status' => 'hadir', 'catatan' => 'Patroli jam 01.00 dan 03.00 aman'],
                    ['warga_idx' => 7, 'status' => 'hadir', 'catatan' => 'Aman terkendali'],
                ],
            ],
            [
                'tanggal_ronda' => '2026-10-22',
                'shift_ronda' => 'Malam (22:00 - 04:00)',
                'keterangan_khusus' => 'Jadwal Ronda Malam ini - Waspada cuaca hujan',
                'participants' => [
                    ['warga_idx' => 8, 'status' => 'hadir', 'catatan' => 'Siap piket malam ini'],
                    ['warga_idx' => 9, 'status' => 'hadir', 'catatan' => 'Siap piket malam ini'],
                    ['warga_idx' => 10, 'status' => 'hadir', 'catatan' => 'Siap piket malam ini'],
                    ['warga_idx' => 11, 'status' => 'hadir', 'catatan' => 'Siap piket malam ini'],
                ],
            ],
            [
                'tanggal_ronda' => '2026-10-23',
                'shift_ronda' => 'Malam (22:00 - 04:00)',
                'keterangan_khusus' => 'Jadwal Ronda Besok Malam',
                'participants' => [
                    ['warga_idx' => 12, 'status' => 'hadir', 'catatan' => null],
                    ['warga_idx' => 13, 'status' => 'hadir', 'catatan' => null],
                    ['warga_idx' => 14, 'status' => 'hadir', 'catatan' => null],
                    ['warga_idx' => 15, 'status' => 'hadir', 'catatan' => null],
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
                            'status_kehadiran' => $p['status'],
                            'catatan_keterangan' => $p['catatan'],
                        ]
                    );
                }
            }
        }
    }
}
