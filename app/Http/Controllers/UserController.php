<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use app\Models;

class ProductController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function input()
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
    
    /*
    public function detail($product_master_id)
    {
        $details = ProductDetailMaster::with([
            'ProductImageMaster' => function ($query) {
                $query->orderBy('product_image_path_id', 'asc');
            },
            'ProductMaster' => function ($query) use ($product_master_id) {
                $query->where('product_master_id', $product_master_id);
            }
        ])->whereHas('ProductMaster', function ($query) use ($product_master_id) {
            $query->where('product_master_id', $product_master_id);
        })
        ->get();
    
        // 結果のフィルタリングして、それぞれのProductDetailMasterに対応するProductImageMasterのデータのみ取得
        foreach ($details as $detail) {
            $detail->productImageMaster = $detail->productImageMaster->filter(function ($image) use ($detail) {
                return $image->product_id == $detail->product_id;
            });
        }
    
        return $details;
    }
*/
    
}


