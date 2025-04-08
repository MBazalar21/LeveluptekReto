<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicles extends Model
{
    protected $fillable = ['name'];
    public function peoples() {
        return $this->belongsToMany(People::class, 'people_vehicle');
    }
}
