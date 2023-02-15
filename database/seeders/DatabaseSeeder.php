<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Jurusan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $jurusans = [
            [
                'kode' => 'T01',
                'nama' => 'Teknik Informatika',
            ],
            [
                'kode' => 'T02',
                'nama' => 'Sistem Informasi',
            ],
            [
                'kode' => 'T03',
                'nama' => 'Desain Komunikasi Visual',
            ],
            [
                'kode' => 'F01',
                'nama' => 'Akuntansi',
            ]
        ];

        foreach($jurusans as $jurusan){
            Jurusan::updateOrCreate($jurusan, [
                'kode' => $jurusan['kode'],
            ]);
        }
    }
}
