<?php

namespace App\Models;

use illuminate\database\eloquent\model;

class Contact extends model
{
    protected $table = 'contacts';

    protected $fillable = [
        'name',
        'phone',
        'email',
        'subject',
        'message',
    ];
}
