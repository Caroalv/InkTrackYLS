<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';
    protected $fillable = ['groupname'];

    public function subgroups()
    {
        return $this->hasMany(Subgroup::class, 'groupid');
    }
}