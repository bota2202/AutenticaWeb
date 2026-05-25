<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['cpf' => '000.000.000-00'],
            [
                'name' => 'Administrador',
                'email' => 'admin@autentica.local',
                'phone' => '(00) 00000-0000',
                'role' => 'admin',
                'password' => 'admin123',
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['cpf' => '111.111.111-11'],
            [
                'name' => 'Professor Teste',
                'email' => 'professor@autentica.local',
                'phone' => '(11) 11111-1111',
                'role' => 'professor',
                'password' => 'prof123',
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['cpf' => '222.222.222-22'],
            [
                'name' => 'Responsável Teste',
                'email' => 'responsavel@autentica.local',
                'phone' => '(22) 22222-2222',
                'role' => 'responsavel',
                'password' => 'resp123',
                'is_active' => true,
            ]
        );

        User::where('cpf', '333.333.333-33')->delete();
    }
}
