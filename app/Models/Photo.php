<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
  public function Album()
  {
    $this->belongsTo('App\Models\Album');
  }
}
