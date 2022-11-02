<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
    use Notifiable;

    protected $table = "_USER"

    public function going_events() {return $this->belongsToMany('App/Models/Event')}

    public function events_owned() {return $this->belongsToMany('App/Models/Event')}
}
