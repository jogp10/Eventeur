<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model {
    use HasFactory;

    protected $table = "TICKET"

    public $timestamps = false

    public $fillable = [
        'price'
    ]

    public function event() {return $this->hasOne('App/Models/Event');}
}
