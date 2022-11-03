<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoverImage extends Model {
    use HasFactory;

    protected $table = "CoverImage"

    public $timestamps = false

    public $fillable = [
        'path'
    ]

    public function account() {return $this->belongsTo('App/Models/Account');} 
}
