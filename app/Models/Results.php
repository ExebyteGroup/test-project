<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Results extends Model
{
    use HasFactory;

    protected $with = ['answers', 'questions'];

    public function answers()
    {
        return $this->hasOne(Answer::class, 'id','answer_id');
    }

    public function questions()
    {
        return $this->hasOne(Question::class, 'id','question_id');
    }
}
