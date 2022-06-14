<?php

namespace App\Models;

use illuminate\database\eloquent\model;

class Page extends model
{
    protected $table = 'pages';
    protected $fillable = [
        'name',
        'content',
    ];
}
