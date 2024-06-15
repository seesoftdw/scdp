<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Soe_master extends Model
{
    protected $table = 'soe_master';
    protected $primaryKey = 'id';
    protected $fillable = ['department_id','majorhead_id','scheme_id','soe_name'];
    
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function majorhead()
    {
        return $this->belongsTo(Majorhead::class);
    }

    public function scheme()
    {
        return $this->belongsTo(Scheme_master::class);
    }
}