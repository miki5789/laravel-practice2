<?php

namespace Database\Seeders;
use App\Models\ProductMaster;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product = array("リュックサック", "ショルダーバッグ", "クラッチバッグ");
        $brand = array("Adidas", "COACH", "GUCCI");
        $category = "Bag";
        $price = 10000;
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                    ProductMaster::create([
                        'product_name' => $brand[$j] ." ". $product[$i],
                        'brand' => $brand[$j],
                        'category' => $category,
                        //'price' => $price,
                        'delete_flg' => false
                ]);
                $price = $price*1.1;
            }
        }
    }
}
