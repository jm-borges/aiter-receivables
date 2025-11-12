<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@teste.com',
            'password' => bcrypt('123456'),
            'is_super_admin' => true,
        ]);

        User::create([
            'name' => 'Fornecedor teste',
            'email' => 'fornecedor@teste.com',
            'password' => bcrypt('123456'),
            'is_super_admin' => false,
        ]);
    }
}
