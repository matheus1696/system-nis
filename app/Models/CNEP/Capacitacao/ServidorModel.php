<?php

namespace App\Models\CNEP\Capacitacao;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Config\Funcao\FuncaoModel;
use App\Models\Config\Unidade\UnidadeModel;

class ServidorModel extends Model
{
    use HasFactory;

    protected $table = 'tb_servidores';

    public function tb_unidades(){
        return $this->belongsTo(UnidadeModel::class, 'unidade_id');
    }

    public function tb_funcoes(){
        return $this->belongsTo(FuncaoModel::class, 'funcao_id');
    }
}
