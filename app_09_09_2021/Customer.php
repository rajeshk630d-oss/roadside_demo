<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function salesperson()
    {
        return $this->hasOne('App\Salesman' , 'id' , 'sales_person_id');
    }
}
