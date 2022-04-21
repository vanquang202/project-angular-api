<?php

namespace App\Models;

use App\Services\ApiControllerManager\V1\TApiController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Question extends Model
{
    use HasFactory, TApiController;
    protected $table = 'questions';
    protected $guarded = [];
    public $timestamps = false;

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}