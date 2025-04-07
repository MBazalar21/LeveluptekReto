<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Planet extends Model
{
    protected $fillable = ['name'];
    
    public function peoples() {
        return $this->hasMany(People::class);
    }
}
