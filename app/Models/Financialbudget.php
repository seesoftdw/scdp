<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Financialbudget extends Model
{
  protected $table = 'soe_financial_budget';
    protected $primaryKey = 'id';
    protected $fillable = ['department_id','majorhead_id','scheme_id','soe_id','fin_year_id','outlay','district_id','plan_id'];

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
