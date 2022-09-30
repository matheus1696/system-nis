<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Config\BlocoModel;

class BlocosSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        BlocoModel::create([
            'name' => 'Atenção Primária',
            'cor' => 'primary',
        ]);
        BlocoModel::create([
            'name' => 'Atenção Especializada',
            'cor' => 'danger',
        ]);
        BlocoModel::create([
            'name' => 'Gestão e Governancia',
            'cor' => 'success',
        ]);
    }
}
