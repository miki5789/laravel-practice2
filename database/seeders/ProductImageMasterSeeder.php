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
    public function run(): void
    {
        for ($i = 1; $i <= 8; $i++) {   
            ProductImageMaster::create([
                'product_id' => $i,
                'image_path1' => "/img" . "/" . $i . "_" . "1.png",
                'image_path2' => "/img" . "/" . $i . "_" . "2.png",
                'image_path3' => "/img" . "/" . $i . "_" . "3.png", 
                'delete_flg' => false,
            ]);
        }
    }
}
