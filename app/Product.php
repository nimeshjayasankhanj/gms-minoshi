<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table='product';
    protected $primaryKey='idproduct';

    public function Category(){
        return $this->belongsTo(Category::class,'category_idcategory');
    }
   
    public function POTempory(){
        return $this->hasMany(POTempory::class,'product_idproduct');
    }

    public function GRNTemp(){
        return $this->hasMany(GRNTemp::class,'product_idproduct');
    }

    public function ItemInvReg(){
        return $this->hasMany(ItemInvReg::class,'product_idproduct');
    }

    public function TempBooking(){
        return $this->hasMany(TempBooking::class,'product_idproduct');
    }

    public function BookingReg(){
        return $this->hasMany(BookingReg::class,'product_idproduct');
    }
    

}