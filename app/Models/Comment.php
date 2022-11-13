<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model {
    use HasFactory;

    protected $table = "comment";

    public $timestamps = false;

    protected $fillable = [
        'content', 'date', 'edited'
    ];

    public function replies() {return $this->belongsToMany('App\Models\Comment');}
    
    public function notification() {return $this->hasOne('App\Models\CommentNotification');}
}
