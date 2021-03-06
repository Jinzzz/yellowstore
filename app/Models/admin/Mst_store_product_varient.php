<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class Mst_store_product_varient extends Model
{
    protected $primaryKey = 'product_varient_id';

    protected $fillable = [
      
     	'product_id','product_varient_price','product_varient_offer_price','product_varient_offer_from_date','product_varient_offer_to_date','product_varient_base_image','product_id','store_id','stock_count','attr_group_id','attr_value_id',
 					
 					];

 	public function store()
   {
   	return $this->belongsTo('App\Models\admin\Trn_store_customer','customer_id','customer_id');
   } 
   public function product()
   {
   	return $this->belongsTo('App\Models\admin\Mst_store_product','product_id','product_id');
   }
   public function product_name()
   {
   	return $this->belongsTo('App\Models\admin\Mst_store_product','product_id','product_id');
   }
   
   public function attr_value()
   {
    return $this->belongsTo('App\Models\admin\Mst_attribute_value','attr_value_id','attr_value_id');
   } 

    public function attr_group()
   {
    return $this->belongsTo('App\Models\admin\Mst_attribute_group','attr_group_id','attr_group_id');
   } 

}
