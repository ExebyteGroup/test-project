<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ResultParameter;

class Answer extends Model
{
    use HasFactory;

    protected $with = ['parameter'];

    public function parameter()
    {
        return $this->hasOne(ResultParameter::class, 'id','result_id');
    }
}

