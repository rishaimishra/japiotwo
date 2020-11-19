<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class UserDataset extends Model
{
       protected $table = 'user_dataset';
	    protected $primaryKey = 'Id';
	   public $timestamps = false;
}
