<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\User;

class Account extends Authenticatable {
    use HasFactory;

    public $timestamps  = false;

    protected $table = "account";

    protected $fillable = [
        'name', 'email', 'description', 'age', 'password' 
    ];

    protected $hidden = [
        'password'
    ];

    public function coverImage() {return $this->hasOne('App\Models\CoverImage');} 
    
    public function perfilPicture() {return $this->hasOne('App\Models\PerfilPicture');}

    public function user() {return $this->hasOne('App\Models\User');}

    public function admin() {return $this->hasOne('App\Models\Administrator');}
}






