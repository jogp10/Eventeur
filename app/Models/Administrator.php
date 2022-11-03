<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrator extends Model {
    use HasFactory;

    protected $table = "administrator"

    public $timestamps = false

    public function account() {return $this->belongsTo('App/Models/Account')}
}
