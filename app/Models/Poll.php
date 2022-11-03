<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model {
    use HasFactory;

    protected $table = "poll"

    public $timestamps = false

    public $fillable = [
        'question'
    ]

    public function options() {return $this->belongsToMany('App/Models/PollOption');}

    
    
}
