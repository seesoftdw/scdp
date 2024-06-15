<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    
    protected $table = 'components';
    protected $primaryKey = 'id';
    protected $fillable = ['component_name'];
}