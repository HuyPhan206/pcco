<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

    
class Product extends Model
{
    protected $fillable = ['name', 'price', 'discount_price', 'description', 'image', 'stock', 'category_id'];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}