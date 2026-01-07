<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateTicketDummy extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $nims = DB::table('tickets')->pluck('nim')->toArray();

        $nama_mahasiswa = [
            'Ahmad Fauzi',
            'Budi Santoso',
            'Citra Lestari',
            'Dewi Anggraini',
            'Eko Prasetyo',
            'Fajar Ramadhan',
            'Gita Permata',
            'Hadi Wijaya',
            'Intan Maharani',
            'Joko Susilo',
            'Kartika Sari',
            'Lukman Hakim',
            'Maya Salsabila',
            'Nanda Putri',
            'Oka Pratama',
            'Putri Aulia',
            'Rizki Maulana',
            'Sari Wulandari',
            'Taufik Hidayat',
            'Umar Faruq',
            'Vina Oktaviani',
            'Wahyu Setiawan',
            'Yani Kurniawati',
            'Zaki Alamsyah',
            'Andi Saputra',
            'Bella Novita',
            'Chandra Gunawan',
            'Dian Puspitasari',
            'Farhan Akbar',
            'Nisa Rahmawati',
        ];

        $categoryIds = DB::table('categories')->pluck('id')->toArray();

        $statusList = ['baru', 'proses', 'selesai', 'ditolak'];

        $judulList = [
            'Masalah Jaringan',
            'Aplikasi Error',
            'Komputer Rusak',
            'Data Tidak Muncul',
            'Pelayanan Lambat',
            'Login Gagal',
            'Fasilitas Rusak',
            'Permintaan Informasi',
            'Keluhan Mahasiswa',
            'Laporan Keamanan',
        ];

        $deskripsiList = [
            'Mohon segera ditindaklanjuti.',
            'Masalah ini sudah terjadi beberapa hari.',
            'Sangat mengganggu aktivitas perkuliahan.',
            'Mohon penjelasan lebih lanjut.',
            'Perlu perbaikan secepatnya.',
            'Terjadi secara tiba-tiba.',
            'Harap diperiksa oleh pihak terkait.',
        ];

        $tickets = [];

        for ($i = 1; $i <= 30; $i++) {
            $tickets[] = [
                'nim' => $nims[array_rand($nims)],
                'nama_mahasiswa' => $nama_mahasiswa[array_rand($nama_mahasiswa)],
                'judul' => $judulList[array_rand($judulList)],
                'deskripsi' => $deskripsiList[array_rand($deskripsiList)],
                'category_id' => $categoryIds[array_rand($categoryIds)],
                'status' => $statusList[array_rand($statusList)],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('tickets')->insert($tickets);
    }
}
