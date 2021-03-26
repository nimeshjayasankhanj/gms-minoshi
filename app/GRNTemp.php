<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class GRNTemp extends Model
{
    protected $table='grn_temp';
    protected $primaryKey='idgrn_temp';

    public function Product(){
        return $this->belongsTo(Product::class,'product_idproduct');
    }
    public function Category(){
        return $this->belongsTo(Category::class,'category_idcategory');
    }
}