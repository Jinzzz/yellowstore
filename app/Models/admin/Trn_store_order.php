<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class Trn_store_order extends Model
{
   protected $primaryKey = "order_id";

    protected $fillable = [
    					    'order_id','order_number','customer_id','order_item_id','product_varient_id','store_id','product_total_amount','quantity','shipping_address','country_id','state_id','district_id','shipping_landmark','shipping_pincode','coupon_discount_percentage','delivery_date','payment_type_id','status_id',
    					        						  ];

    public function store()
   {
   	return $this->belongsTo('App\Models\admin\Mst_store','store_id','store_id');
   }

     public function subadmin()
   {
   	return $this->belongsTo('App\User','subadmin_id','id');
   }

     public function product_varient()
   {
   	return $this->belongsTo('App\Models\admin\Mst_store_product_varient','product_varient_id','product_varient_id');
     // return $this->product_varient_id;
   }

   public function product()
   {
   return $this->belongsTo('App\Models\admin\Mst_store_product_varient','product_varient_id');
    }

    public function customer()
   {
   	return $this->belongsTo('App\Models\admin\Trn_store_customer','customer_id','customer_id');
   }

   public function country()
   {
   	return $this->belongsTo('App\Models\admin\Country','country_id','country_id');
   }

   public function delivery_boy()
   {
   	return $this->belongsTo('App\Models\admin\Mst_delivery_boy','delivery_boy_id','delivery_boy_id');
   }

//    public function delivery_boy()
//    {
//    	return $this->belongsTo('App\Models\admin\Mst_delivery_boy','delivery_boy_id','delivery_boy_id');
//    }

   public function state()
   {
   	return $this->belongsTo('App\Models\admin\State','state_id','state_id');
   }
	public function district()
   {
   	return $this->belongsTo('App\Models\admin\District','district_id','district_id');
   }
   public function status()
   {
   	return $this->belongsTo('App\Models\admin\Sys_store_order_status','status_id','status_id');
   }
   public function payment_type()
   {
   	return $this->belongsTo('App\Models\admin\Sys_payment_type','payment_type_id','payment_type_id');
   }
    public function order_item()
   {
    return $this->belongsTo('App\Models\admin\Trn_store_order_item','order_item_id','order_item_id');
   }
}
