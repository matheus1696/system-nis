<?php

namespace App\Models\Config;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Config\BlocoModel;
use App\Models\Config\StatusUnidadeModel;

class UnidadeModel extends Model
{
    use HasFactory;
    protected $table = 'tb_config_unidades';

    public function tb_config_blocos(){
        return $this->belongsTo(BlocoModel::class, 'bloco_id');
    }

    public function tb_config_status_unidades(){
        return $this->belongsTo(StatusUnidadeModel::class, 'status_id');
    }
}
