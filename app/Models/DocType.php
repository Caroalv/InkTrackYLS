<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocType extends Model
{
    protected $table = 'doc_types';
    protected $fillable = ['kind', 'doctype', 'doctypefullname'];

    public function movHeaders()
    {
        return $this->hasMany(MovHeader::class, 'doctypeid');
    }
}