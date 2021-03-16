<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Stock;
use App\Models\Product;
use App\Models\Retailer;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TrackCommandTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_tracks_product_stock()
    {
        $switch = Product::create(['name' => 'Nintendo Switch']);

        $bestBuy = Retailer::create(['name' => 'Best Buy']);

        $this->assertFalse($switch->inStock());

        $stock = new Stock([
            'price'=> 1000,
            'url'=> 'http://foo.com',
            'sku'=> '12345',
            'in_stock' => false
        ]);

        $bestBuy->addStock($switch, $stock);

        $this->assertFalse($stock->fresh()->in_stock);

        Http::fake(function () {
            return [
                'available' => true,
                'price' => 99,
            ];
        });

        $this->artisan('track');

        $this->assertTrue($stock->fresh()->in_stock);
    }
}
