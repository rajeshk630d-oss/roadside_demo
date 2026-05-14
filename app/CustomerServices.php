<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerServices extends Model
{
    public function customer()
    {
        return $this->hasOne('App\Customer' , 'id' , 'customer_id');
    }
    public function service()
    {
        return $this->hasOne('App\Service' , 'id' , 'service_id');
    }

}
