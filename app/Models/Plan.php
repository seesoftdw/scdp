<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'plans';
    protected $primaryKey = 'id';
    protected $fillable = ['plan_name'];
}