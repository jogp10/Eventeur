<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model {
    use HasFactory;

    protected $table = "COMMENT"

    public function replies() {return $this->belongsToMany('App/Models/Comment');}
    
}
