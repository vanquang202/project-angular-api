<?php

namespace App\Models;

use App\Services\ApiControllerManager\V1\TApiController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Role extends Model
{
    use HasFactory, TApiController;
    protected $table = 'roles';
    protected $guarded = [];
    public $timestamps = false;
}