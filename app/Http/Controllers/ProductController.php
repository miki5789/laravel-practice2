<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\ProductMaster;
use App\Models\ProductImageMaster;
use App\Models\ProductDetailMaster;
use app\Models;

class ProductController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index()
    {
        $products = ProductMaster::with([
            'ProductDetailMaster' => function ($query) {
                $query->orderBy('product_id', 'asc');
            },
            'ProductImageMaster' => function ($query) {
                $query->orderBy('product_image_path_id', 'asc');
            },
        ])->get();
        return $products;
    }

    public function detail($product_id)
    {
        console.log($product_id);
        $details = ProductDetailMaster::with(['productMaster', 'productImageMaster'])
            ->where('product_master_id', $product_master_id)
            ->get();
        //$details = ProductDetailMaster::with('productDetailMaster', 'productImageMaster');

        //console.log($product_master_id);

        return $details;

    }
}


