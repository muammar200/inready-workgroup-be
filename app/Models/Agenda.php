<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Agenda extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ["id"];
    protected $dispatchesEvents = [
        "creating" => SetCreatedBy::class,
        "saving" => SetUpdatedBy::class,
    ];

    public function sluggable(): array
    {
        return [
            "slug" => [
                "source" => "title",
            ],
        ];
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
