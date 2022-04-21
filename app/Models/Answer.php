<?php

namespace App\Models;

use App\Services\ApiControllerManager\V1\TApiController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Answer extends Model
{
    use HasFactory, TApiController;
    protected $table = 'answers';
    protected $guarded = [];
    public $timestamps = false;
    // protected $hidden  = ['is_correct'];

    public function questions()
    {
        return $this->belongsTo(Question::class, 'question_id')->with('answers');
    }
}