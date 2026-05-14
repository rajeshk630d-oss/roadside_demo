<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contractor extends Model
{
    public function service_country()
    {
        return $this->hasOne('App\ServiceCountry' , 'id' , 'service_country_master_id');
    }
    public function service_area()
    {
        return $this->hasOne('App\ServiceAreas' , 'id' , 'area_id');
    }

}
