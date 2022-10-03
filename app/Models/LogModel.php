<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class LogModel extends Model
{
    use HasFactory;
    protected $table = "tb_logs";

    public function users(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
