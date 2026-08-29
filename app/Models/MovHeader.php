<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovHeader extends Model
{
    protected $table = 'mov_headers';
    protected $fillable = [
        'doctypeid',
        'supplierid',
        'docnumber',
        'docdate',
        'YLSindate',
        'SPindate',
    ];

    public function docType()
    {
        return $this->belongsTo(DocType::class, 'doctypeid');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplierid');
    }

    public function details()
    {
        return $this->hasMany(MovDetail::class, 'headerid');
    }
}