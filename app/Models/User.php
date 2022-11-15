<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class User extends Model
{
    use Notifiable;

    protected $fillable = [
        'account_id', 'created_at', 'updated_at'
    ];

    public function account() { return $this->hasOne(Account::class); }
    public function events() { return $this->hasMany(Event::class); }

    public function profileImage() { return $this->hasOne(ProfileImage::class); }

    public function tickets() { return $this->hasMany(Ticket::class); }

    public function invites() { return $this->hasMany(Invite::class); }

    public function comments() { return $this->hasMany(Comment::class); }

    public function answers() { return $this->hasMany(Answer::class); }

    public function votes() { return $this->hasMany(Vote::class); }

    public function reports() { return $this->hasMany(Report::class); }

    public function ban() { return $this->belongsTo(Ban::class); }

    
}
