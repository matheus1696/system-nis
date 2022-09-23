<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\HasPermission;

class Permission extends Model
{
    use HasFactory;

    protected $table = 'permissions';

    public function hasPermission(){
        return $this->belongsTo(HasPermission::class);
    }
}
