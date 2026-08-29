<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovDetail extends Model
{
    protected $table = 'mov_details';
    protected $fillable = [
        'headerid',
        'itemid',
        'qty',
        'realweight',
    ];

    public function header()
    {
        return $this->belongsTo(MovHeader::class, 'headerid');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'itemid');
    }

    public function dyeloteMovDetails()
    {
        return $this->hasMany(DyeloteMovDetail::class, 'movdetailsid');
    }
}