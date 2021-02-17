<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{

   /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = [
      'idProdi', 'name', 'number'
   ];

   /**
    * The attributes excluded from the model's JSON form.
    *
    * @var array
    */
   protected $hidden = [];
}
