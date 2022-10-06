<?php

namespace App\Models\TI\ProcessosLicitatorio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\TI\ProcessosLicitatorio\StatusProcessosLicModel;
use App\Models\TI\ProcessosLicitatorio\TiposProcessosLicModel;

class ProcessoLicModel extends Model
{
    use HasFactory;
    protected $table = 'tb_ti_processos_lic';    

    public function tb_ti_status_processos_lic(){
        return $this->belongsTo(StatusProcessosLicModel::class, 'status_id');
    }   

    public function tb_ti_tipos_processos_lic(){
        return $this->belongsTo(TiposProcessosLicModel::class, 'tipos_id');
    }
}
