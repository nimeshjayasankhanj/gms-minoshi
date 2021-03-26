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
    protected $table='meta_user_role';
    protected $primaryKey='idMeta_User_Role';

    public function User(){
        return $this->hasMany(User::class,'Meta_User_Role');
    }

}