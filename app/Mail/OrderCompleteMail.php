<?php

// app/Mail/OrderCompleteMail.php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\MailMaster;

class OrderCompleteMail extends Mailable
{
    use Queueable, SerializesModels;

    
    public function __construct($userData, $cartData, $totalPrice, $order_id)
    {
        $productInfo = [];

        // テンプレートデータを取得
        $template = MailMaster::where('mail_content', '注文完了メール')->first();
        \Log::info('OrderCompleteMail');
        $postcode = $userData['postcode'];
        $postcodeWithHyphen = substr($postcode, 0, 3) . '-' . substr($postcode, 3);

        if ($template) {
            // 注文番号をメール本文に反映
            $this->body = str_replace('{{苗字}}', $userData['surname'], $template->mail_body);
            $this->body = str_replace('{{名前}}', $userData['given_name'], $this->body);
            $this->body = str_replace('{{苗字カナ}}', $userData['surname_kana'], $this->body);
            $this->body = str_replace('{{名前カナ}}', $userData['given_name_kana'], $this->body);
            $this->body = str_replace('{{郵便番号}}', $postcodeWithHyphen, $this->body);
            $this->body = str_replace('{{県}}', $userData['prefecture'], $this->body);
            $this->body = str_replace('{{住所}}', $userData['city'] . $userData['street'] . $userData['room'], $this->body);
            $this->body = str_replace('{{注文ID}}', $order_id, $this->body);
            


            // テンプレートが見つかった場合に `template` プロパティに格納
            foreach ($cartData as $product) {
                \Log::info($product);
                $price = $product['productDetails']['price'];
                $formattedPrice = number_format($price);
                $formattedTotalPrice = number_format($totalPrice);
                $temp2 = "";
                $temp = 
                '<p>{{商品名}} {{カラー}} </p>
                <p>¥{{単価}} × {{数量}}点</p>
                <hr style="border: 1px solid #cccccc; margin-top: 10px; margin-bottom: 10px;">';     

                $temp2 = str_replace('{{商品名}}', $product['productDetails']['product_master']['product_name'], $temp);
                $temp2 = str_replace('{{カラー}}', $product['productDetails']['color'], $temp2);
                $temp2 = str_replace('{{単価}}', $formattedPrice, $temp2);
                $temp2 = str_replace('{{数量}}', $product['selectedQuantity'], $temp2);

                $productInfo[] = $temp2;
            }

            // すべての商品テンプレートを連結
            $allProductData = implode('', $productInfo);

            // `{{商品データ}}` をすべての商品の情報で置き換える
            $this->body = str_replace('{{商品データ}}', $allProductData, $this->body);
            $this->body = str_replace('{{小計}}', $formattedTotalPrice, $this->body);

            $this->template = [
                'mail_from' => $template->mail_from,
                'mail_title' => $template->mail_title,
                'mail_body' => $this->body
            ];
            
        }

        \Log::info('test');
        \Log::info($template->mail_from);
        \Log::info($template->mail_title);
        \Log::info($template->mail_content);
        \Log::info($this->body);
    }

    
    public function build()
    {
        return $this->from($this->template['mail_from'])
                    ->subject($this->template['mail_title'])
                    ->text('')
                    ->html($this->body);
    }
    
}



