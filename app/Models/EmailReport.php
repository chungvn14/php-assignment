<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailReport extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'report_date',
        'total_email',
        'success_email',
        'failed_email',
    ];
}
