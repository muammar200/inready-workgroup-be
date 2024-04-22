<?php
namespace App\Models\Events;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class SetCreatedBy 
{
  public function __construct(Model $model) {
    if (Auth::check() && Schema::hasColumn($model->getTable(), 'created_by')) {
      $model->created_by = Auth::user()->id;
    }
  }
}
