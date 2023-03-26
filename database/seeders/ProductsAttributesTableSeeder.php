<?php

namespace Database\Seeders;

use App\Models\ProductsAttribute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsAttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productAttributesRecords = [
          [
           'id'=>1,
           'product_id'=>2,
           'size'=>'Small',
           'price'=>1000,
           'stock'=>10,
           'sku'=>'RC001-S',
           'status'=>1,
          ],
          [
            'id'=>2,
            'product_id'=>2,
            'size'=>'Medium',
            'price'=>1100,
            'stock'=>15,
            'sku'=>'RC001-M',
            'status'=>1,
           ],
            [
            'id'=>3,
            'product_id'=>2,
            'size'=>'Large',
            'price'=>1200,
            'stock'=>20,
            'sku'=>'RC001-L',
            'status'=>1,
           ],
        ];
        ProductsAttribute::insert($productAttributesRecords);
    }
}
