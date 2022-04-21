<?php

namespace App\Models;

use App\Services\ApiControllerManager\V1\TApiController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class StudentQuiz extends Model
{
    use HasFactory, TApiController;
    protected $table = 'student_quizs';
    protected $primaryKey = 'id';
    protected $fillable = [
        'student_id',
        'quiz_id',
        'start_time',
        'end_time',
        'score',
    ];
    public $timestamps = false;
    public function student_quiz_detail()
    {
        return $this->hasMany(StudentQuizDetail::class, 'student_quiz_id')->with('answers');
    }
    public function quizs()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id')->with('subject');
    }
}