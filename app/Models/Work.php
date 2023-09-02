<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    public function member() {
        return $this->belongsTo(Member::class, "member_id");
    }

    public function creator() {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function editor() {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
