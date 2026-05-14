<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerContracts extends Model
{
    public function customer()
    {
        return $this->hasOne('App\Customer' , 'id' , 'customers_id');
    }
    public function service()
    {
        return $this->hasOne('App\Service' , 'id' , 'service_master_id');
    }
}
