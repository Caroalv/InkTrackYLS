<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';
    protected $fillable = [
        'subgroupid',
        'muid',
        'phcode',
        'itemname',
        'unitestimatedweight',
        'minstock',
        'maxstock',
        'currentstock',
        'estimatedunitweight',
    ];

    public function subgroup()
    {
        return $this->belongsTo(Subgroup::class, 'subgroupid');
    }

    public function measurementUnit()
    {
        return $this->belongsTo(MeasurementUnit::class, 'muid');
    }

    public function movDetails()
    {
        return $this->hasMany(MovDetail::class, 'itemid');
    }

    public function dyelotes()
    {
        return $this->hasMany(Dyelote::class, 'itemid');
    }
}