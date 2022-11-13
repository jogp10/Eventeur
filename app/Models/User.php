<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
    use Notifiable;

    protected $table = "users";

    public $timestamps = false;

    public function going_events() {return $this->belongsToMany('App\Models\Event');}

    public function events_owned() {return $this->belongsToMany('App\Models\Event');}

    public function account() {return $this->belongsTo('App\Models\Account');}

    public function invites() {return $this->belongsToMany('App\Models\Event')->withPivot('content');}

    public function votes() {return $this->belongsToMany('App\Models\PollOption');}

    public function tickets() {return $this->belongsToMany('App\Models\Ticket');}

    public function comment() {return $this->hasMany('App\Models\Comment');}

    public function inviteNotification() {$this->hasOne('App\MOdels\InviteNotification');}

}
