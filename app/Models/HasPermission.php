<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasPermission extends Model
{
    use HasFactory;
    protected $table = 'model_has_permissions';
    public $timestamps = false;
}
