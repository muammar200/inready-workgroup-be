<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BPO extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'bpo';

    public function member(){
        return $this->belongsTo(Member::class);
    }

    public function position(){
        return $this->belongsTo(Presidium::class, 'presidium_id', 'id');
    }

    public function division(){
        return $this->belongsTo(Division::class);
    }

}
