<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded=['id','created_at','updated_at'];

    public function order_details(){
        return $this->hasMany(Order_detail::class);
    }

    public function client(){
        return $this->belongsTo(Client::class);
    }
}
