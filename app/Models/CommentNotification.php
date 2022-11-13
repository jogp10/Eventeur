<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentNotification extends Model {
    use HasFactory;

    protected $table = "CommentNotification";

    public $timestamps = false;

    public function comment() {return $this->belongsTo('App\Models\Comment');}
}
