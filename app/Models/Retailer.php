<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Retailer extends Model
{
    public function addStock(Product $product, Stock $stock)
    {
        $stock->product_id = $product->id;

        $this->stock()->save($stock);
    }

    public function stock()
    {
        return $this->hasMany(Stock::class);
    }
}
