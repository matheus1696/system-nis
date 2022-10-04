<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Config\StatusUnidadeModel;

class StatusUnidadeSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        StatusUnidadeModel::create([
            'name' => 'Ativo',
        ]);
        StatusUnidadeModel::create([
            'name' => 'Reforma',
        ]);
        StatusUnidadeModel::create([
            'name' => 'Desativado',
        ]);
    }
}
