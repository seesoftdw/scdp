<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Soe_budget_allocation extends Model
{
    protected $table = 'soe_budget_allocation';
    protected $primaryKey = 'id';
    protected $fillable = ['department_id',
                        'majorhead_id',
                        'scheme_id',
                        'soe_id',
                        'fin_year_id',
                        'earmarked',
                        'plan_id',
                        'service_id',
                        'sector_id',
                        'subsector_id',
                        'hod_outlay',
                        'district_outlay',
                        'outlay',
                        ];

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
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }
    public function subsector()
    {
        return $this->belongsTo(Subsector::class);
    }
}
