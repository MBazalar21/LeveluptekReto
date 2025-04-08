<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QueryLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'resource_type',
        'resource_id',
    ];

}
