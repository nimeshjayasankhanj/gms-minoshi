<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table='supplier';
    protected $primaryKey='idsupplier';

    public function User(){
        return $this->belongsTo(User::class,'master_user_idmaster_user');
    }
    public function MasterGrn(){
        return $this->hasMany(MasterGrn::class,'supplier_idsupplier');
    }
    public function PurchaseOrder(){
        return $this->hasMany(PurchaseOrder::class,'supplier_idsupplier');
    }

}