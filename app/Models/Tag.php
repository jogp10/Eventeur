<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model {
    use HasFactory;

    protected $table = "TAG"

    public $timestamps = false

    public $fillable = [
        'name'
    ]

    public function events() {return $this->belongsToMany("App/Models/Event")}
}
