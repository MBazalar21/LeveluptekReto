<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    protected $fillable = ['name','planet_id'];
    
    public function planet() {
        return $this->belongsTo(Planet::class);
    }
    
    public function films() {
        return $this->belongsToMany(Film::class, 'people_film');
    }
    
    public function vehicles() {
        return $this->belongsToMany(Vehicles::class, 'people_vehicle');
    }
    
    public function species() {
        return $this->belongsToMany(Species::class, 'people_species');
    }
}
