<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // TODO: mudar os nomes para se algo como "can:algo"
        Permission::create(['name' => 'view requesition']);
        Permission::create(['name' => 'create requesition']);
        Permission::create(['name' => 'edit requesition']);
        Permission::create(['name' => 'manage logs audit']); // Só o Admin terá
        Permission::create(['name' => 'view logs audit']);

        // Role Usuario
        $user = Role::create(['name' => 'usuario']);
        $user->givePermissionTo(['view requesition', 'create requesition', 'edit requesition']);

        // Role Gerente
        $gerente = Role::create(['name' => 'gerente']);
        $gerente->givePermissionTo(['view requesition', 'create requesition', 'edit requesition']);

        // Role Admin
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all()); // Tem tudo, inclusive 'manage logs'

        $getUserAdmin = User::where('id',1)->first();
        $getUserAdmin->assignRole($admin);
    }
}
