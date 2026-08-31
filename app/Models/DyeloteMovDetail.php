<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DyeloteMovDetail extends Model
{
    protected $table = 'dyelote_mov_details';
    protected $fillable = [
        'movdetailsid',
        'itemid',
        'dyelote',
        'duedate',
        'MSDS',
        'qtyxlote',
        'weightxlote',
        'movdetailsid_IN',
    ];

    public function movDetail()
    {
        return $this->belongsTo(MovDetail::class, 'movdetailsid');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'itemid');
    }
}