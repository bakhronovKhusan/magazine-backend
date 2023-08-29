<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         \App\Models\User::factory(10)->create();

         \App\Models\User::factory()->create([
             'name'     => 'admin',
             'email'    => 'admin@admin.com',
             'password' => '12345678',
         ]);

        // Создание разрешения
        $createPost = Permission::firstOrCreate(['name' => 'create post']);
        $editPost   = Permission::firstOrCreate(['name' => 'edit post']);

// Создание роли
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole  = Role::firstOrCreate(['name' => 'user']);

        $adminRole->givePermissionTo([$createPost, $editPost]);
        $userRole->givePermissionTo($createPost);


    }
}
