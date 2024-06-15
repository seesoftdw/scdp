<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scheme_master extends Model
{

    protected $table = 'scheme_master';
    protected $primaryKey = 'id';
    protected $fillable = ['department_id','majorhead_id','scheme_name'];
    
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function majorhead()
    {
        return $this->belongsTo(Majorhead::class);
    }
}