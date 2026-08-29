<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subgroup extends Model
{
    protected $table = 'subgroups';
    protected $fillable = ['groupid', 'subgroupname'];

    public function group()
    {
        return $this->belongsTo(Group::class, 'groupid');
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'subgroupid');
    }
}