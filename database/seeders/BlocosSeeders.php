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
            'sigla' => 'ATB',
            'cor' => 'primary',
        ]);
        BlocoModel::create([
            'name' => 'Atenção Especializada',
            'sigla' => 'ATE',
            'cor' => 'danger',
        ]);
        BlocoModel::create([
            'name' => 'Gestão e Governancia',
            'sigla' => 'ADM',
            'cor' => 'success',
        ]);
        BlocoModel::create([
            'name' => 'Vigilância Epdemiológica',
            'sigla' => 'V. EPD',
            'cor' => 'info',
        ]);
        BlocoModel::create([
            'name' => 'Vigilância Sanitária',
            'sigla' => 'V. SAN',
            'cor' => 'warning',
        ]);
    }
}
