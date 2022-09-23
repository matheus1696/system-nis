<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UserSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            'name' => 'Administrador do Sistema',
            'email' => 'sysadmin',
            'password' => Hash::make('admin@123'),
        ])->givePermissionTo(['super_adm','admin','user']);

        User::create([
            'name' => 'Usuário Administrador',
            'email' => 'useradmin',
            'password' => Hash::make('admin@123'),
        ])->givePermissionTo(['admin','user']);

        User::create([
            'name' => 'Usuário Comum',
            'email' => 'user',
            'password' => Hash::make('user@123'),
        ])->givePermissionTo('user');
    }
}
