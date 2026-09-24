<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'suppliers';

    protected $fillable = [
        'suppliername',
        'contactname',
        'phone',
        'email',
        'address',
    ];

    public function movHeaders()
    {
        return $this->hasMany(MovHeader::class, 'supplierid');
    }
}