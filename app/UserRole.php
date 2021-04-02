<?php
/**
 * Created by PhpStorm.
 * User: Nimesh VGS
 * Date: 12/13/2019
 * Time: 2:37 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $table='user_role';
    protected $primaryKey='iduser_role';

    public function User(){
        return $this->hasMany(User::class,'user_role_iduser_role');
    }

}