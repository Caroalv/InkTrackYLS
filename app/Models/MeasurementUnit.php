<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeasurementUnit extends Model
{
    protected $table = 'measurement_units';
    protected $fillable = ['mesureunitname'];

    public function items()
    {
        return $this->hasMany(Item::class, 'muid');
    }
}