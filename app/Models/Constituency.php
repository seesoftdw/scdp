<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Constituency extends Model
{

    protected $table = 'constituencys';
    protected $primaryKey = 'id';
    protected $fillable = ['district_id','constituencys_name'];

    public function district()
    {
        return $this->belongsTo(District::class);
    }
}