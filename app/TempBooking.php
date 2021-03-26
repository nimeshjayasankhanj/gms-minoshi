<?php
/**
 * Created by PhpStorm.
 * User: Nimesh VGS
 * Date: 12/13/2019
 * Time: 2:37 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class TempBooking extends Model
{
    protected $table='temp_booking';
    protected $primaryKey='idtemp_booking';

    public function Product(){
        return $this->belongsTo(Product::class,'product_idproduct');
    }
   

}