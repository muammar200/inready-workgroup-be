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

    public function creator() {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function editor() {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function user() {
        return $this->hasOne(User::class, "member_id");
    }
}
