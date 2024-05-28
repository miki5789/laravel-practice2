<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\OrderProduct;
use App\Models\OrderUser;
use App\Models\ProductDetailMaster;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderCompleteMail;
use App\Models\MailMaster;
use App\Models\MailLog;
use Illuminate\Support\Facades\Log;

class OrderController extends BaseController
{   
    use AuthorizesRequests, ValidatesRequests;
    public $template;
    public $surname;
    public $given_name;
    public $order_id;

    public function confirm(Request $request){
        try{
            DB::beginTransaction();
            \Log::info('confirmIn'); 
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
                \Log::info($cart);
                $orderProduct = new OrderProduct();
                $orderProduct->order_id = $order_id;
                $orderProduct->product_id = $cart['productDetails']['product_id'];
                $orderProduct->order_quantity = $cart['selectedQuantity'];
                $orderProduct->unit_price = $cart['productDetails']['price'];
                $orderProduct->order_date = $orderDate;
                $orderProduct->delete_flg = false;
                $orderProduct->save();
                $totalPrice = $totalPrice + ($cart['productDetails']['price'] * $cart['selectedQuantity']);

                //在庫数変更
                $product = ProductDetailMaster::where('product_id', $cart['productDetails']['product_id'])->first();
                $originalQuantity = $product->quantity;
                $newQuantity = $originalQuantity - $cart['selectedQuantity'];
                $product->update(['quantity' => $newQuantity]); // キーと値のペアで指定
                \Log::info($product->quantity);
            }

            $orderUser->update(['total_price' => $totalPrice]);
            $this->sendOrderCompleteMail($userData, $cartData, $totalPrice, $order_id);
            DB::commit(); //save
        }catch(\Exception $e){
            DB::rollBack(); 
        }
            
        return $order_id;
        
    }

    public function sendOrderCompleteMail($userData, $cartData, $totalPrice, $order_id)
    {

        \Log::info($userData['email']);
        try{
            $orderCompleteMail = new OrderCompleteMail($userData, $cartData, $totalPrice, $order_id);
            Mail::to($userData['email'])->send(new OrderCompleteMail($userData, $cartData, $totalPrice, $order_id));
            $orderCompleteMail->createLog($submit_result = 1, $order_id);
            
        }catch(\Exception $e){
            //失敗したメールログ
            $orderCompleteMail->createLog($submit_result = 2, $order_id);
        }
    }
}


