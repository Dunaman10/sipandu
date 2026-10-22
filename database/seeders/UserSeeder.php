<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Administrator Sistem',
                'username' => 'admin',
                'email' => 'admin@sipandu.test',
                'password' => Hash::make('password'),
                'no_hp' => '081234567890',
                'role' => 'admin',
                'is_active' => true,
            ],
            [
                'name' => 'H. Bambang Sutrisno (Ketua RT 03)',
                'username' => 'ketua_rt',
                'email' => 'ketuart@sipandu.test',
                'password' => Hash::make('password'),
                'no_hp' => '081298765432',
                'role' => 'ketua_rt',
                'is_active' => true,
            ],
            [
                'name' => 'Hj. Siti Rohmah (Bendahara RT 03)',
                'username' => 'bendahara',
                'email' => 'bendahara@sipandu.test',
                'password' => Hash::make('password'),
                'no_hp' => '081311223344',
                'role' => 'bendahara',
                'is_active' => true,
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['username' => $userData['username']],
                $userData
            );
        }
    }
}
