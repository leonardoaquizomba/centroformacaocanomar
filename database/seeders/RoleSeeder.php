<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['admin', 'professor', 'aluno'];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        // Create test admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@canomar.ao'],
            [
                'name' => 'Administrador',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole('admin');

        // Create test teacher user
        $teacher = User::firstOrCreate(
            ['email' => 'professor@canomar.ao'],
            [
                'name' => 'Professor Teste',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        $teacher->assignRole('professor');

        // Create test student user
        $student = User::firstOrCreate(
            ['email' => 'aluno@canomar.ao'],
            [
                'name' => 'Aluno Teste',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        $student->assignRole('aluno');
    }
}
