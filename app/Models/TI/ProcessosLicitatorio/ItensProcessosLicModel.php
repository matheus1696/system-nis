<?php

namespace App\Models\TI\ProcessosLicitatorio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\TI\ProcessosLicitatorio\ProcessoLicModel;

class ItensProcessosLicModel extends Model
{
    use HasFactory;
    protected $table = 'tb_ti_processos_lic_itens';    

    public function tb_ti_processos_lic(){
        return $this->belongsTo(ProcessoLicModel::class, 'pl_id');
    }
}
