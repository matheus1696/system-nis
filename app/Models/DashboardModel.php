<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Config\BlocoModel;
use App\Models\Config\IconModel;

class DashboardModel extends Model
{
    use HasFactory;    
    protected $table = 'tb_dashboard';

    public function tb_config_blocos(){
        return $this->belongsTo(BlocoModel::class, 'bloco_id');
    }

    public function tb_config_icons(){
        return $this->belongsTo(IconModel::class, 'icons_id');
    }
}
