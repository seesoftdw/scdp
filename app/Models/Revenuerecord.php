<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Revenuerecord extends Model
{
    protected $table = 'revenuerecord';
  
    protected $fillable = ['enterWorkCode',
                        'enterWorkName',
                        'enterEstimateCost',
                        'enterAA_ES',
                        'budgetProvidedTillPreviousYear',
                        'budgetUtilizeTillDatepreviousYear',
                        'fundsRequiredForCompletion',
                        'SelectType',
                        'SelectWork',
                        'selectOriginalScopeOfWork',
                        'workCategory',
                        'dispute',
                        'fca',
                        'enterDetail',
                        'priority',
                        'pow',
                        'category',
                        'uploadInvoice',
                        'SucessStories',
                        'sechmeId',
                        ];

   
}
