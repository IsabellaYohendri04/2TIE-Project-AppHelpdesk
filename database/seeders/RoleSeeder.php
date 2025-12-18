<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cache permission (Wajib agar tidak error)
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Buat role
        $roleAdmin = Role::firstOrCreate(['name' => 'admin']);
        $roleStaff = Role::firstOrCreate(['name' => 'staff']);

        // 2. Buat Akun ADMIN
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole($roleAdmin);

        // 3. Buat Akun Staff BIASA
        // Perhatikan: variabel diubah dari $roleStaff menjadi $userStaff
        $userStaff = User::firstOrCreate(
            ['email' => 'staff@gmail.com'], // Gunakan huruf kecil untuk email agar konsisten
            [
                'name' => 'Staff Biasa',
                'password' => Hash::make('password'),
            ]
        );
        
        // Hubungkan User Staff dengan Role Staff
        $userStaff->assignRole($roleStaff); 
    }
}