<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CityMaster;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

// database/seeders/CitysTableSeeder.php
class CityMasterSeeder extends Seeder
{
    function run()
    {
        $file = fopen(base_path('database/postcode/city.txt'), 'r');

        while (($data = fgetcsv($file)) !== FALSE) {
            CityMaster::create([
                'city_name' => $data[1],
                'city_code' => $data[0],
                'prefecture_code' => $data[2],
                'delete_flg' => false,
            ]);
        }

        fclose($file);
    }
}
