<?php

namespace Database\Seeders;
use App\Models\ProductDetailMaster;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductDetailMasterSeeder extends Seeder
{
    //return $this->belongsTo('App\User');
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $color = array("カラー1", "カラー2", "カラー3");
        $quantity = 2;
        $price = 20000;
        for ($i = 4; $i <= 9; $i++) {
            for ($j = 0; $j < 3; $j++) {
                    if ($quantity == 13){
                        $quantity = 1;
                    };
                    ProductDetailMaster::create([
                        'color' => $color[$j],
                        'price' => $price,
                        'quantity' =>$quantity,
                        'product_master_id' => $i,
                        'delete_flg' => false,
                    ]);
                $price = $price*1.1;
                $quantity += 2;
            }
        }
    }
}
