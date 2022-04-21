<?php

namespace App\Models;

use App\Services\ApiControllerManager\V1\TApiController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Subject extends Model
{
    use HasFactory, TApiController;
    protected $table = 'subjects';
    protected $fillable = ['name', 'author_id'];
    public $timestamps = false;
    protected $withCount = ['quizs'];
    protected $appends  = ['slug_name'];

    public function getSlugNameAttribute()
    {
        return \Str::slug($this->name);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function quizs()
    {
        return $this->hasMany(Quiz::class);
    }
}