<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Permission;

class PermissionsSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Permission::create([
            'name' => 'super_adm',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'user',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'dashboard',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'capacitacao',
            'guard_name' => 'web'
        ]);
    }
}
