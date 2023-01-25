<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecentView extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function Item(){
        return Product::where('id', $this->product_id)->where('status', 1)
                    ->with('categories','assignAttributes','offer', 'offer.activeOffer', 'reviews', 'productImages', 'stocks')
                    ->whereHas('categories')->first();
    }
    public function product(){
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
