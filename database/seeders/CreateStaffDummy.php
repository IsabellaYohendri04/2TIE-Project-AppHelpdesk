<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class CreateStaffDummy extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $categoryIds = Category::pluck('id');

        foreach (range(1, 100) as $i) {

            // 1. Buat USER
            $staff = User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
            ]);

            // 2. Kasih ROLE staff (WAJIB)
            $staff->assignRole('staff');

            // 3. Hubungkan CATEGORY (pivot)
            $staff->categories()->attach(
                $categoryIds->random(rand(1,3))->toArray()
            );
        }
    }
}
