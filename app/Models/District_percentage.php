<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District_percentage extends Model
{

    protected $table = 'district_percentage';
    protected $primaryKey = 'id';
    protected $fillable = ['district_id','percentage'];

    public function district()
    {
        return $this->belongsTo(District::class);
    }
}