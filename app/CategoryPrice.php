<?php
/**
 * Created by PhpStorm.
 * User: Nimesh VGS
 * Date: 12/13/2019
 * Time: 2:37 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class CategoryPrice extends Model
{
    protected $table='category_price';
    protected $primaryKey='idcategory_price';

    public function MainCategory(){
        return $this->belongsTo(MainCategory::class,'main_category_idmain_category');
    }

}