<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\Jadwal;
use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@siakad.test'],
            [
                'name' => 'Administrator SIAKAD',
                'password' => 'password',
                'role' => 'admin',
            ]
        );

        Dosen::updateOrCreate(
            ['nidn' => '0412345678'],
            ['nama' => 'Dr. Budi Santoso, M.Kom.']
        );

        Dosen::updateOrCreate(
            ['nidn' => '0487654321'],
            ['nama' => 'Siti Rahma, M.Kom.']
        );

        $mahasiswaUser = User::updateOrCreate(
            ['email' => 'mahasiswa@siakad.test'],
            [
                'name' => 'Muhammad Faizal',
                'password' => 'password',
                'role' => 'mahasiswa',
            ]
        );

        Mahasiswa::updateOrCreate(
            ['npm' => '5520124051'],
            [
                'user_id' => $mahasiswaUser->id,
                'nidn' => '0412345678',
                'nama' => 'Muhammad Faizal',
            ]
        );

        MataKuliah::updateOrCreate(
            ['kode_matakuliah' => 'IF53413'],
            ['nama_matakuliah' => 'Web II', 'sks' => 3]
        );

        MataKuliah::updateOrCreate(
            ['kode_matakuliah' => 'IF53101'],
            ['nama_matakuliah' => 'Basis Data II', 'sks' => 3]
        );

        MataKuliah::updateOrCreate(
            ['kode_matakuliah' => 'IF53202'],
            ['nama_matakuliah' => 'Rekayasa Perangkat Lunak', 'sks' => 3]
        );

        Jadwal::updateOrCreate(
            [
                'kode_matakuliah' => 'IF53413',
                'kelas' => 'A',
            ],
            [
                'nidn' => '0412345678',
                'hari' => 'Senin',
                'jam_mulai' => '08:00',
                'jam_selesai' => '10:30',
            ]
        );

        Jadwal::updateOrCreate(
            [
                'kode_matakuliah' => 'IF53101',
                'kelas' => 'A',
            ],
            [
                'nidn' => '0487654321',
                'hari' => 'Rabu',
                'jam_mulai' => '10:30',
                'jam_selesai' => '13:00',
            ]
        );

        Krs::firstOrCreate([
            'npm' => '5520124051',
            'kode_matakuliah' => 'IF53413',
        ]);
    }
}
