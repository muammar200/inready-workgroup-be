<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Events\SetCreatedBy;
use App\Models\Events\SetUpdatedBy;

class Slider extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    protected $dispatchesEvents = [
        "creating" => SetCreatedBy::class,
        "saving" => SetUpdatedBy::class,
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function editor()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
