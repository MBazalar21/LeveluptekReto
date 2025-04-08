<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Planet extends Model
{
    protected $fillable = ['name','climate','terrain','population'];
    
    public function people() {
        return $this->hasMany(People::class);
    }
}
