<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model {
    use HasFactory;
    
    protected $table = "EVENTS"

    public PRIVACY = [
        'public', 'private'
    ]

    public $timestamps = false;

    protected $fillable = [
        'name', 'num_tickets', 'description'
    ]

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ]

    public function users(){return $this->belongsToMany('App\Models\User');}

    public function tags(){return $this->belongsToMany('App/Models/Tag');}

    public function reports() {return $this->hasMany('App/Models/Report');}

    public function polls() {return $this->hasMany('App/Models/Poll');}

    public function comments() {return $this->hasMany('App/Models/Comment');}

    public function invites() {return $this->belongsToMany('App/Models/User')->withPivot('content');}

    public function tickets() {return $this->hasMany('App/Models/Ticket')}
}
