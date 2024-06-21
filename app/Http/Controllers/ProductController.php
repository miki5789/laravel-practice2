<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\ProductMaster;
use App\Models\ProductImageMaster;
use App\Models\ProductDetailMaster;
use app\Models;
use Illuminate\Http\Request;

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

    //商品検索
    public function search(Request $request) {

        \Log::info('detailHeader:'); 
        \Log::info($request->body); 
        // キーワード配列をリクエストから取得
        $keywords = $request->input('keywords', []);
    
        // 親クエリの初期化
        $query = ProductMaster::with([
            'ProductDetailMaster' => function ($query) {
                $query->where('quantity', '>=', 1);
            },
            'ProductImageMaster' => function ($query) {
                $query->orderBy('product_image_path_id', 'asc');
            }
        ]);
    
        // キーワードが指定されている場合に AND 条件で検索
        if (!empty($keywords)) {
            // 各キーワードに対して AND 条件でフィルタリング
            foreach ($keywords as $keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('product_name', 'like', '%' . $keyword . '%')
                        ->orWhere('category', 'like', '%' . $keyword . '%')
                        ->orWhere('brand', 'like', '%' . $keyword . '%')
                        ->orWhere('keywords', 'like', '%' . $keyword . '%');
                });
            }

        }
    
        // 結果を取得
        $products = $query->get();
    
        return response()->json($products);
    }
    
    public function checkInventory(Request $request)
    {
        //$cart = $request->input('cart');
        \Log::info('checkInventoryIn'); 
        \Log::info($request);
        $cartData = $request->input('cart');
        
        //\Log::info($cartData); 
        //\Log::info(gettype($cartData)); 
        foreach ($cartData as $cartItem) {
            \Log::info('checkCartItem'); 
            \Log::info($cartItem); 
            \Log::info($cartItem['selectedQuantity']); 
            
            $product = ProductDetailMaster::where('product_id', $cartItem['productDetails']['product_id'])->first();
            \Log::info($product['quantity']); 
            if ($product['quantity'] < $cartItem['selectedQuantity']) {
                return response()->json([
                    'isStockAvailable' => false,
                    'product_id' => $cartItem['productDetails']['product_id'],
                    'remainingStock' => $product['quantity']
                ]);
            }
        }
        return response()->json(['isStockAvailable' => true]);
    }

    
    
    
    
}


