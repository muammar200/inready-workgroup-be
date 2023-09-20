<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presidium extends Model
{
    use HasFactory;

    protected $table = 'presidiums';
    protected $guarded = ['id'];

    public function divisions(){
        return $this->hasMany(Division::class);
    }
}
