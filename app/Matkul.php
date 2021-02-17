<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matkul extends Model
{

   /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = [
      'idSemester', 'name', 'code', 'sessionExam', 'sksNumber'
   ];

   /**
    * The attributes excluded from the model's JSON form.
    *
    * @var array
    */
   protected $hidden = [];
}
