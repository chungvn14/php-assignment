<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Email extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'emails';

    /// Mass assignable
    protected $fillable = [
        'email',
        'subject',
        'body',
        'attachment_path',
        'status',
        'attempts',
    ];

  protected $attributes = [
        'attempts' => 0, // cột attempts sẽ mặc định là 0
        'status' => 'pending', // ví dụ cột status
    ];
    
}


