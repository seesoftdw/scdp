<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class DocumentsRevenue extends Model
{
	
	 protected $table = 'document_revenue';
    protected $fillable = [
        'uploadInvoice','user_id','revenue_id'
    ];

    
}