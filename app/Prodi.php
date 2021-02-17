<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{

   /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = [
      'idJurusan', 'name', 'code'
   ];

   /**
    * The attributes excluded from the model's JSON form.
    *
    * @var array
    */
   protected $hidden = [];
}
