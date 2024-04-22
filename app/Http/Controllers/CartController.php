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
                $query->where('quantity', '>=', 1);
                $query->orderBy('product_id', 'asc');
            },
            'ProductImageMaster' => function ($query) {
                $query->orderBy('product_image_path_id', 'asc');
            },
        ])->get();
        return $products;
    }
    
}


