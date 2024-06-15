<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Sector extends Model
{
    
    protected $table = 'sectors';
    protected $primaryKey = 'id';
    protected $fillable = ['service_id','department_id','sector_name'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}