<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\TI\ProcessosLicitatorio\StatusProcessosLicModel;

class StatusProcessosLicSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        StatusProcessosLicModel::create([
            'name' => 'Solicitado',
            'cor' => 'info',
        ]);
        StatusProcessosLicModel::create([
            'name' => 'Elaboração de TR',
            'cor' => 'info',
        ]);
        StatusProcessosLicModel::create([
            'name' => 'Processo Publicado',
            'cor' => 'info',
        ]);
        StatusProcessosLicModel::create([
            'name' => 'Parecer Técnico',
            'cor' => 'info',
        ]);
        StatusProcessosLicModel::create([
            'name' => 'Concluído',
            'cor' => 'success',
        ]);
        StatusProcessosLicModel::create([
            'name' => 'Vencido',
            'cor' => 'danger',
        ]);        
        StatusProcessosLicModel::create([
            'name' => 'Saldo Zerado',
            'cor' => 'danger',
        ]);
    }
}
