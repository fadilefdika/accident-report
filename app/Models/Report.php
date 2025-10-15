<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'reports';  
    protected $fillable = [
        'report_type',
        'location',
        'incident_date',
        'reported_by',
        'description',
        'attachment'
    ];
    public $timestamps = true; 
}