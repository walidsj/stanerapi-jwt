<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{

   /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = [
      'idSemester', 'name', 'npm', 'gender', 'yearGeneration', 'yearGraduation', 'class', 'numberAbsen'
   ];

   /**
    * The attributes excluded from the model's JSON form.
    *
    * @var array
    */
   protected $hidden = [];
}
