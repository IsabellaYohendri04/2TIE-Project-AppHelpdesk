<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;

class CreateTicketDummy extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $now = Carbon::now();

        $statusList = ['baru', 'proses', 'selesai','ditolak'];

        // Ambil category id (wajib ada)
        $categoryIds = DB::table('categories')->pluck('id')->toArray();

        $tickets = [];

        for ($i = 1; $i <= 30; $i++) {
            $tickets[] = [
                'nim' => $faker->unique()->numerify('########'), // angka acak
                'nama_mahasiswa' => $faker->name(),
                'judul' => $faker->sentence(3),
                'deskripsi' => $faker->paragraph(),
                'category_id' => $categoryIds[array_rand($categoryIds)],
                'status' => $statusList[array_rand($statusList)],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('tickets')->insert($tickets);
    }
}
