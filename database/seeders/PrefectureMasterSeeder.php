<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PrefectureMaster;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

// database/seeders/PrefecturesTableSeeder.php
class PrefectureMasterSeeder extends Seeder
{
    function run()
    {
        $file = fopen(base_path('database/postcode/prefecture.csv'), 'r');

        while (($data = fgetcsv($file)) !== FALSE) {
            PrefectureMaster::create([
                'prefecture_name' => $data[1],
                'prefecture_id' => $data[0],
                'delete_flg' => false,
            ]);
        }

        fclose($file);
    }
}
