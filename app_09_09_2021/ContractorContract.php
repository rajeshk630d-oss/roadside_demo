<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContractorContract extends Model
{
    public function contractor()
    {
        return $this->hasOne('App\Contractor' , 'id' , 'contractor_master_id');
    }
    public function service()
    {
        return $this->hasOne('App\Service' , 'id' , 'service_master_id');
    }
}
