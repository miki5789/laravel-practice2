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

        return $order_id;
        
    }

    public function sendOrderCompleteMail($userData, $cartData, $totalPrice, $order_id)
    {
        /*
        // テスト用
        $mockRequestData = [
            'surname' => '田中',
            'given_name' => '洋子',
            'order_id' => '12345',
            'email' => 'kobayashi.m@doublecrown.jp'
        ];

        // テスト用のデータをリクエストから取得されたものとして使用
        $surname = $mockRequestData['surname'];
        $given_name = $mockRequestData['given_name'];
        $order_id = $mockRequestData['order_id'];
        $recipient_email = $mockRequestData['email'];
        
        // リクエストからデータを取得
        
        $surname = $request->input('surname');
        $given_name = $request->input('given_name');
        
        $order_id = $request->input('order_id');
        $recipient_email = $request->input('email');

        
        // Mailable クラスを使ってメールを送信
        $data = [
            'surname' => $surname,
            'given_name' => $given_name,
            'order_id' => $order_id,
            'email' => $recipient_email
        ];
*/
        //$this->orderUserData = ;
        //$this->$orderProductData = $request->input('cart_data');

        //$orderCompleteMail = new OrderCompleteMail(Request request);
        //\Log::info('sendOrderCompleteMailin');
        //\Log::info($orderUser);
        //\Log::info($orderProduct);

        \Log::info($userData['email']);
        Mail::to($userData['email'])->send(new OrderCompleteMail($userData, $cartData, $totalPrice, $order_id));
        /*
        $response = [
            'surname' => $orderCompleteMail->surname,
            'given_name' => $orderCompleteMail->given_name,
            'order_id' => $orderCompleteMail->order_id,
            'email' => $recipient_email,
            'title' => $orderCompleteMail->template['mail_title'], // メールタイトル
            'body' => $orderCompleteMail->template['mail_body'] // メール本文
        ];
        return response()->json($response);
        */
    }

    public function createMailLog(Request $request){

    }
}


