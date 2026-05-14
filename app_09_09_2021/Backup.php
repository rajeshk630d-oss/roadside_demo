<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Backup extends Model
{
    public function user()
    {
        return $this->hasOne('App\User' , 'id' , 'user_id');
    }
}
