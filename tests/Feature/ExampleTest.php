<?php

namespace Tests\Feature;

use App\Models\Discount;
use App\Models\Product;
use App\Models\SeasonDiscount;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $product = Product::where('id',2)->first();






        dd($product->getDiscountPersent());
    }
}
