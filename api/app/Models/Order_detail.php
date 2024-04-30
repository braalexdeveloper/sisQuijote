<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_detail extends Model
{
    use HasFactory;

    protected $guarded=['id','created_at','updated_at'];

    public function book(){
        return $this->belongsTo(Book::class);
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }
}
