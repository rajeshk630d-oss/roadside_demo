<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    public function membership_type()
    {
        return $this->hasOne('App\MembershipType' , 'id' , 'membership_type_id');
    }
    public function customer()
    {
        return $this->hasOne('App\Customer' , 'id' , 'customer_id');
    }
}
