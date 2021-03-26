<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

    class Stock extends Model
{
    protected $table='stock';
    protected $primaryKey='idstock';

    public function Product(){
        return $this->belongsTo(Product::class,'product_idproduct');
    }
    public function User(){
        return $this->belongsTo(User::class,'master_user_idmaster_user');
    }

        public function MasterCompany(){
            return $this->belongsTo(MasterCompany::class,'master_company');
        }
}