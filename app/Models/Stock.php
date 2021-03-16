<?php

namespace App\Models;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stock';

    protected $casts = [
        'in_stock' => 'boolean'
    ];

    public function retailer()
    {
        return $this->belongsTo(Retailer::class);
    }

    public function track()
    {
        if ($this->retailer->name === 'Best Buy') {
            // hit an API endpoint for the associated retailer
            // fetch up-to-date details for the item
            $results = Http::get('http://foo.test')->json();

            // then update the current stock record
            $this->update([
                'in_stock' => $results['available'],
                'price' => $results['price'],
            ]);
        }
    }
}
