<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar usuário admin
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@carbono.com',
            'password' => Hash::make('password'),
        ]);

        // Criar usuários de teste usando factory
        User::factory(5)->create();

        // Criar alguns usuários específicos para testes
        User::create([
            'name' => 'João Silva',
            'email' => 'joao@teste.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Maria Santos',
            'email' => 'maria@teste.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Pedro Costa',
            'email' => 'pedro@teste.com',
            'password' => Hash::make('password'),
        ]);
    }
}
