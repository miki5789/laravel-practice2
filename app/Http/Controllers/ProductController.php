<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\ProductMaster;
use app\Models;

class ProductController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    public function index(){
        //\Log::debug('testaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa');
        $products = ProductMaster::with(['productDetailMaster' => function($query){
            $query->orderBy('product_id', 'asc');
        }])->get(); 
        return $products;
    }

}


