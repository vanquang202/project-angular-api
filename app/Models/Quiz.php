<?php

namespace App\Models;

use App\Services\ApiControllerManager\V1\TApiController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Quiz extends Model
{
    use HasFactory, TApiController;
    protected $table = 'quizs';
    protected $guarded = [];
    public $timestamps = false;
    protected $appends  = ['slug_name'];

    protected $withCount = ['questions'];

    public function getSlugNameAttribute()
    {
        return \Str::slug($this->name);
    }

    public function questions()
    {
        return $this->hasMany(Question::class)->with('answers');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}