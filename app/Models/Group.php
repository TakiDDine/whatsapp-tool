<?php

namespace App\Models;

use illuminate\database\eloquent\model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends model
{
    protected $table = 'groups';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function groupNumbers(): HasMany
    {
        return $this->hasMany(GroupNumber::class);
    }
}
