<?php

namespace App\Models;

use illuminate\database\eloquent\model;

class Number extends model
{
    protected $table = 'numbers';
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
