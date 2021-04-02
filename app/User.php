<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;


    protected $table= 'user_master';
    protected  $primaryKey='iduser_master';

    public function MasterBooking(){
        return $this->hasMany(MasterBooking::class,'user_master_iduser_master');
    }

    public function UserRole(){
        return $this->belongsTo(UserRole::class,'user_role_iduser_role');
    }

    
}
