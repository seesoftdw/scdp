<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subsector extends Model
{

    protected $table = 'subsectors';
    protected $primaryKey = 'id';
    protected $fillable = ['service_id','department_id','sector_id','subsectors_name'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }
}
