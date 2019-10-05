<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exercise extends Model 
{

    protected $table = 'exercises';
    public $timestamps = false;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

}