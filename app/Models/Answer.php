<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $table = "answer";

    public $timestamps = false;

    protected $fillable = [
        'comment_id', 'answer_id'
    ];

    public function replies()
    {
        $answers = $this->hasMany('App\Models\Comment', 'id');
        foreach($answers as $answer) {
            $answer->comment = $this;
        }
        return $answers;
    }

    public function repliedTo()
    {
        $comment = $this->belongsTo('App\Models\Comment', 'id');
        if (isset($comment->answers)) {
            $comment->answers->merge($comment);
        }
        return $comment;
    }

}
