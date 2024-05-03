<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\OrderProduct;
use App\Models\OrderUser;

class OrderController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function confirm(Request $request){
        $userData = $request->input('userData');
        $cartData = $request->input('cartData');
        \Log::info($cartData); 
        $orderDate = now();

        $orderUser = new OrderUser();
        $orderUser->surname = $userData['surname'];
        $orderUser->given_name = $userData['given_name'];
        $orderUser->surname_kana = $userData['surname_kana'];
        $orderUser->given_name_kana = $userData['given_name_kana'];
        $orderUser->post_code = $userData['postcode'];
        $orderUser->prefecture = $userData['prefecture'];
        $orderUser->address = $userData['city'] . $userData['street'] . $userData['room'];
        $orderUser->email = $userData['email'];
        $orderUser->order_date = $orderDate;
        $orderUser->delete_flg = false;

        $orderUser->save();
        
        \Log::info($orderUser);
        $order_id = $orderUser->order_id;
        $totalPrice = 0;

        foreach ($cartData as $cart) {

            $orderProduct = new OrderProduct();
            $orderProduct->order_id = $order_id;
            $orderProduct->product_id = $cart['productDetails']['product_id'];
            $orderProduct->order_quantity = $cart['selectedQuantity'];
            $orderProduct->unit_price = $cart['productDetails']['price'];
            $orderProduct->order_date = $orderDate;
            $orderProduct->delete_flg = false;
            $orderProduct->save();

            $totalPrice = $totalPrice + ($cart['price'] * $cart['selectedQuantity']);
        }

        $orderUser->update(['total_price' => $totalPrice]);

        return $order_id;
        
    }

    
}


