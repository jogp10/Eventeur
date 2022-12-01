<?php

//namespace Carbon\Carbon;
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Event extends Model {
    use HasFactory;

    protected $types = [
        'Fitness',
        'Nature',
        'Sports',
        'Geography'
    ];

    protected $fillable = [
        'name', 'description', 'start_date', 'end_date', 'location', 'capacity', 'privacy', 'user_id', 'ticket', 'created_at', 'updated_at', 'tsvectors'
    ];

    public function manager() { return $this->belongsTo(User::class, 'user_id'); }

    public function coverImage() { return $this->hasOne(CoverImage::class); }

    public function tags() { return $this->belongsToMany(Tag::class); }

    public function tickets() { return $this->hasMany(Ticket::class); }

    public function invites() { return $this->hasMany(Invite::class); }

    public function comments() { return $this->hasMany(Comment::class); }

    public function polls() { return $this->hasMany(Poll::class); }

    public function reports() { return $this->hasMany(Report::class); }

    public function votes() { return $this->hasMany(Vote::class); }

    public function get_start_date_day() {

        $date_array = explode("-", $this->start_date);

        return $date_array[2];
    }

    public function getTagTypes() {

        return $this->types;
    }
}
