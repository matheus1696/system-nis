<?php

namespace App\Models\CNEP\Capacitacao;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Config\Local\LocalModel;

class CapacitacaoModel extends Model
{
    use HasFactory;

    protected $table = 'tb_capacitacoes';

    public function tb_locais_auditorios(){
        return $this->belongsTo(LocalModel::class, 'local_id');
    }
}
