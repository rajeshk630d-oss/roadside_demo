<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = ['id'];
    public function member()
    {
        return $this->hasOne('App\Member' , 'membership_no' , 'member_number');
    }
    public function customer()
    {
        return $this->hasOne('App\Customer' , 'id' , 'customer_id');
    }
    public function service()
    {
        return $this->hasOne('App\Service' , 'id' , 'service_master_id');
    }
    public function vehicle()
    {
        return $this->hasOne('App\Vehicle' , 'id' , 'vehicle_id');
    }
    public function from_service_area()
    {
        return $this->hasOne('App\ServiceAreas' , 'id' , 'from_area');
    }
    public function to_service_area()
    {
        return $this->hasOne('App\ServiceAreas' , 'id' , 'to_area');
    }
    public function contractor()
    {
        return $this->hasOne('App\Contractor' , 'id' , 'contractor_id');
    }
}
