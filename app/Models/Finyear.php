<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finyear extends Model
{    
  protected $table = 'fin-years';
  protected $primaryKey = 'id';
  protected $fillable = ['finyear'];
}
