<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //
    protected $fillable = array('id', 'name', 'last_name', 'second_last_name', 'email', 'birth', 'birth_state');
}
