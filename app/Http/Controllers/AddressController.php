<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\PrefectureMaster;
use App\Models\CityMaster;
use App\Models\PostCodeMaster;
use app\Models;

class AddressController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function prefectures()
    {
        return PrefectureMaster::all();

    }
   


    public function search($postcode)
    {   
        $region = PostCodeMaster::where('post_code', $postcode)->get();
        $address = PostCodeMaster::with([
            'prefecture' => function($query) use ($activePrefecture) {
                if ($activePrefecture) {
                    $query->where('active', 1); // activeが1のものだけ取得
                }
            },
            'city' => function($query) use ($activeCity) {
                if ($activeCity) {
                    $query->where('active', 1); // activeが1のものだけ取得
                }
            }
        ])->where('post_code', $postcode)
          ->get();
    
        return $address;
        }
}


