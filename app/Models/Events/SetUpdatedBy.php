<?php 
namespace App\Models\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
class SetUpdatedBy 
{
  public function __construct(Model $model) {
    if (Auth::check() && Schema::hasColumn($model->getTable(), 'updated_by')) {
      $model->updated_by = Auth::user()->id;
    }
  }
}
