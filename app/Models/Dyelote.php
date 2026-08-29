<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dyelote extends Model
{
    protected $table = 'dyelotes';
    protected $fillable = [
        'movdetailsid_IN',
        'itemid',
        'dyelote',
        'duedate',
        'MSDS',
        'qtyxlote',
        'weightxlote',
        'qtybalance',
        'weightbalance',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'itemid');
    }

    public function movDetailIn()
    {
        return $this->belongsTo(MovDetail::class, 'movdetailsid_IN');
    }
}