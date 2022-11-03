<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerfilPicture extends Model {
    use HasFactory;

    protected $table = "PerfilImage"

    public $timestamps = false

    public $fillable = [
        'path'
    ]

    public function account() {return $this->hasOne('App/Models/Account');}
}
