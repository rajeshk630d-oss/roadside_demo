<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContractorVehicle extends Model
{
    public function contractor()
    {
        return $this->hasOne('App\Contractor' , 'id' , 'contractor_master_id');
    }
    public function vehicle_brand()
    {
        return $this->hasOne('App\VehicleBrandMaster' , 'id' , 'vehicle_brand_master_id');
    }
    public function vehicle_type()
    {
        return $this->hasOne('App\VehicleType' , 'id' , 'vehicle_type_master_id');
    }
    public function vehicle_registration_type()
    {
        return $this->hasOne('App\VehicleRegistrationType' , 'id' , 'vehicle_registration_type_master_id');
    }

}
