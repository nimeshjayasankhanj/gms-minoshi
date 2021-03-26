<?php
/**
 * Created by PhpStorm.
 * User: nimeshjayasankha
 * Date: 6/13/20
 * Time: 6:03 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $table='purchase_order';
    protected $primaryKey='idpurchase_order';

    public function Supplier(){
        return $this->belongsTo(Supplier::class,'supplier_idsupplier');
    }
    public function User(){
        return $this->belongsTo(User::class,'master_user_idmaster_user');
    }
}