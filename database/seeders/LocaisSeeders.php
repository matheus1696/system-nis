<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Config\Local\LocalModel;

class LocaisSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        LocalModel::create([
            'name' => 'Secretaria de Saúde de Caruaru',
        ]);
    }
}
