<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::insert([
            ['name'=>'Network','description'=>'Jaringan'],
            ['name'=>'Hardware','description'=>'Perangkat'],
            ['name'=>'Software','description'=>'Aplikasi'],
            ['name'=>'Janitor','description'=>'Bersih'],
            ['name'=>'BAAK','description'=>'Akademik'],
        ]);
    }
}

