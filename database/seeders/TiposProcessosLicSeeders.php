<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\TI\ProcessosLicitatorio\TiposProcessosLicModel;

class TiposProcessosLicSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //        
        TiposProcessosLicModel::create([
            'name' => 'Fornecimento',
        ]);
        TiposProcessosLicModel::create([
            'name' => 'Serviço',
        ]);
    }
}
