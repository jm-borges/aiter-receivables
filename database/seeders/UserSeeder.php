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
            'id' => '019b329f-265e-70c1-9705-de91ae9db0f6',
            'name' => 'Fornecedor teste',
            'email' => 'fornecedor@teste.com',
            'password' => bcrypt('123456'),
            'is_super_admin' => false,
        ]);
    }
}
