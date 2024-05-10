<?php

namespace Database\Seeders;
use App\Models\ProductImageMaster;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductImageMasterSeeder extends Seeder
{
    //return $this->belongsTo('App\User');
    /**
     * Run the database seeds.
     */
    //商品番号_画像ナンバーなので
    public function run(): void
    {
        for ($i = 25; $i <= 27; $i++) {   
            ProductImageMaster::create([
                'product_id' => $i,
                'image_path1' => "/images" . "/" . $i . "_" . "1.png",
                'image_path2' => "/images" . "/" . $i . "_" . "2.png",
                'image_path3' => "/images" . "/" . $i . "_" . "3.png", 
                'delete_flg' => false,
            ]);
        }
    }
}
