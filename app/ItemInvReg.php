<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class ItemInvReg extends Model
{
    protected $table='item_inv_reg';
    protected $primaryKey='iditem_inv_reg';

    public function Product(){
        return $this->belongsTo(Product::class,'product_idproduct');
    }
  
}