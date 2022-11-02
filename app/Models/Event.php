<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model {
    use HasFactory;
    
    protected $table = "EVENTS"

    public function users(){return $this->belongsToMany('App\Models\User');}

    public function tags(){return $this->belongsToMany('App/Models/Tag');}

    public function reports() {return $this->belongsToMany('App/Models/Report');}

    public function polls() {return $this->belongsToMany('App/Models/Poll');}

    public function comments() {return $this->belongsToMany('App/Models/Comment');}
}
