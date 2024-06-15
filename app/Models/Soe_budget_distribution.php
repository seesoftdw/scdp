<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Soe_budget_distribution extends Model
{
    protected $table = 'soe_budget_distribution';
    protected $primaryKey = 'id';
    protected $fillable = ['department_id','majorhead_id','scheme_id','soe_id','fin_year_id','plan_id','data','q_2_data','q_3_data','q_1_data','q_4_data'];

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
    public function soe()
    {
        return $this->belongsTo(Soe_master::class);
    }
    public function fin_year()
    {
        return $this->belongsTo(Finyear::class);
    }
    public function district()
    {
        return $this->belongsTo(District::class);
    }
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
