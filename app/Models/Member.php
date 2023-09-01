<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    public function major() {
        return $this->belongsTo(Major::class);
    }

    public function concentration() {
        return $this->belongsTo(Concentration::class);
    }
}
