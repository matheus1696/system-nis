<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Config\IconModel;

class IconsSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        IconModel::create([
            'name' => 'Seringa',
            'icons' => '<i class="fas fa-syringe"></i>',
        ]);
        IconModel::create([
            'name' => 'Hospital',
            'icons' => '<i class="fas fa-hospital"></i>',
        ]);
        IconModel::create([
            'name' => 'Prontuário',
            'icons' => '<i class="fas fa-notes-medical"></i>',
        ]);
    }
}
