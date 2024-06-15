<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Majorhead extends Model
{

    protected $table = 'majorhead';
    protected $primaryKey = 'id';
    protected $fillable = ['department_id','mjr_head','sm_head','min_head','sub_head','bdgt_head','complete_head','type'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
