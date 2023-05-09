<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Question extends Model
{
    use HasFactory;

    /**
     * @return Relation
     */
    public function answers(): Relation
    {
        return $this->hasMany(Answer::class, 'question_id', 'id');
    }

    protected $with = [
       'answers'
    ];
}
