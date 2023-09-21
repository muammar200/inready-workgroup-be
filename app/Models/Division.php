<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function bpo()
    {
        return $this->hasMany(BPO::class)->orderBy('is_division_head', 'DESC');
    }

    public function presidium()
    {
        return $this->belongsTo(Presidium::class);
    }
}
