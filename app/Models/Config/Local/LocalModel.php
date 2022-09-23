<?php

namespace App\Models\Config\Local;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocalModel extends Model
{
    use HasFactory;

    protected $table = 'tb_locais_auditorios';
}
