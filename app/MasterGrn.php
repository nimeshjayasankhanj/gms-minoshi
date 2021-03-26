<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class MasterGrn extends Model
{
    protected $table='master_grn';
    protected $primaryKey='idmaster_grn';

    public function Supplier(){
        return $this->belongsTo(Supplier::class,'supplier_idsupplier');
    }
    public function User(){
        return $this->belongsTo(User::class,'master_user_idmaster_user');
    }
}