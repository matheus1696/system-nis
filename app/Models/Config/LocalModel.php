<?php

namespace App\Models\Config;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocalModel extends Model
{
    use HasFactory;

    protected $table = 'tb_config_locais_auditorios';
}
