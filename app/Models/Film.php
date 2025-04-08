<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    protected $fillable = ['title'];
    public function peoples() {
        return $this->belongsToMany(People::class,'people_film');
    }
}
