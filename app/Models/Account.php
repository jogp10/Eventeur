<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Authenticatable {
    use HasFactory;

    public $timestamps  = false;

    protected $table = "ACCOUNT"

    public function coverImage() {return $this->hasOne('App/Models/CoverImage');} 
    
    public function perfilPicture() {return $this->hasOne('App/Models/PerfilPicture');}
}






