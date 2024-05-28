<?php

namespace Database\Seeders;
use App\Models\ProductDetailMaster;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Keywords extends Seeder
{
    //return $this->belongsTo('App\User');
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $color = "ブラック,レッド,ブルー";
        for ($i = 0; $i <= 9; $i++) {
            for ($j = 0; $j <= 9; $j++) {
                    ProductMaster::update([
                        'keywords' => $color,
                    ]);
            }
        }
    }
}
