<?php
/**
 * Created by PhpStorm.
 * User: Nimesh VGS
 * Date: 12/13/2019
 * Time: 2:37 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class MasterBooking extends Model
{
    protected $table='master_booking';
    protected $primaryKey='idmaster_booking';

    public function User(){
        return $this->belongsTo(User::class,'user_master_iduser_master');
    }
  

}