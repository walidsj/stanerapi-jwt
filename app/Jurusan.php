<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{

   /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = [
      'name', 'contactPerson'
   ];

   /**
    * The attributes excluded from the model's JSON form.
    *
    * @var array
    */
   protected $hidden = [];
}
