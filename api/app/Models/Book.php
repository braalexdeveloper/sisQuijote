<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['code','title','description','autor','image','category_id']; // Agrega 'image' a la lista de campos fillable
   

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
