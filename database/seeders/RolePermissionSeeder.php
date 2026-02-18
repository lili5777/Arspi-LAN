<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat role
        $adminRole = Role::create([
            'name' => 'admin',
            'description' => 'Administrator, full access'
        ]);

        $userRole = Role::create([
            'name' => 'user',
            'description' => 'Regular user, limited access'
        ]);

        // buat daftar permission CRUD dasar
        $crudPermissions = [
            'user.create',
            'user.read',
            'user.update',
            'user.delete',
            'role.create',
            'role.read',
            'role.update',
            'role.delete',
        ];

        foreach ($crudPermissions as $perm) {
            Permission::updateOrCreate(
                ['name' => $perm],
                ['description' => "Boleh {$perm} semua data"]
            );
        }

        // hubungkan role admin dengan semua permission
        $allPermissions = Permission::all();
        $adminRole->permissions()->sync($allPermissions->pluck('id')->toArray());

        // hubungkan role user dengan permission read saja
        $readPermissions = Permission::where('name', 'like', '%.read')->get();
        $userRole->permissions()->sync($readPermissions->pluck('id')->toArray());

        // Buat user Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('111'),
            'role_id' => $adminRole->id
        ]);

        // Buat user biasa
        User::create([
            'name' => 'Ali',
            'email' => 'ali@example.com',
            'password' => bcrypt('222'),
            'role_id' => $userRole->id
        ]);

        $kategoris = [
            [
                'name' => 'Berita Acara Usul Pindah',
                'desc' => 'Dokumen berita acara untuk arsip yang diusulkan pindah lokasi penyimpanan',
                'icon' => 'fas fa-file-alt',
                'type' => 'upload',
            ],
            [
                'name' => 'Daftar Arsip Inaktif',
                'desc' => 'Daftar arsip yang sudah tidak aktif digunakan namun masih disimpan',
                'icon' => 'fas fa-archive',
                'type' => 'upload',
            ],
            [
                'name' => 'Daftar Arsip Usul Pindah',
                'desc' => 'Daftar arsip yang diusulkan untuk dipindahkan ke unit kearsipan',
                'icon' => 'fas fa-dolly',
                'type' => 'upload',
            ],
            [
                'name' => 'Daftar Arsip Usul Musnah',
                'desc' => 'Daftar arsip yang diusulkan untuk dimusnahkan sesuai jadwal retensi',
                'icon' => 'fas fa-trash-alt',
                'type' => 'input',
            ],
            [
                'name' => 'Daftar Arsip Vital',
                'desc' => 'Daftar arsip vital yang wajib dilindungi dan dijaga keberadaannya',
                'icon' => 'fas fa-shield-alt',
                'type' => 'input',
            ],
            [
                'name' => 'Daftar Arsip Permanen',
                'desc' => 'Daftar arsip yang disimpan secara permanen karena memiliki nilai guna tinggi',
                'icon' => 'fas fa-infinity',
                'type' => 'input',
            ],
            [
                'name' => 'Arsip Kartografi',
                'desc' => 'Dokumen arsip dalam bentuk peta, gambar teknik, dan dokumen kartografi lainnya',
                'icon' => 'fas fa-map',
                'type' => 'direct',
            ],
        ];

        foreach ($kategoris as $item) {
            Kategori::firstOrCreate(
                ['name' => $item['name']],
                $item
            );
        }
    }
}
