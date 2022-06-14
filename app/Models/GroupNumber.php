<?php

namespace App\Models;

use illuminate\database\eloquent\model;

class GroupNumber extends model
{
    protected $table = 'group_numbers';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function phone()
    {
        return $this->belongsTo(Number::class, 'number_id');
    }
}
