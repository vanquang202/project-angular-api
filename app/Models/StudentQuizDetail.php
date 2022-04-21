<?php

namespace App\Models;

use App\Services\ApiControllerManager\V1\TApiController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class StudentQuizDetail extends Model
{
    use HasFactory, TApiController;
    protected $table = 'student_quiz_detail';
    protected $guarded = [];
    public $timestamps = false;

    public function answers()
    {
        return $this->belongsTo(Answer::class, 'answer_id')->with('questions');
    }
}