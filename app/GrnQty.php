<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class GrnQty extends Model
{
    protected $table='grn_qty';
    protected $primaryKey='idgrn_temp';

    public function Category(){
        return $this->belongsTo(Category::class,'category_idcategory');
    }

    public function Product(){
        return $this->belongsTo(Product::class,'product_idproduct');
    }
}