<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('mail_master')
            ->where('mail_master_id', 1)
            ->update([
            'mail_title' => '【AMOZONA】ご注文ありがとうございます',
            'mail_body' => 
            '<p style="margin-bottom: 20px;>{{苗字}} {{名前}}様</p>"

            <p>ご購入いただきありがとうございます。</p>
            <p style="margin-bottom: 20px;">ご注文内容の確認メールをお送りいたします。</p>
            <p>ご注文番号: {{注文ID}}</p>
            
            <hr style="border: 1px solid #000000; margin-top: 10px; margin-bottom: 10px;">
            <p>お届け先:</p>
            <p>{{郵便番号}}</p>
            <p>{{県}}{{住所}}</p>
            <p style="margin-bottom: 20px;">{{苗字}} {{名前}}（{{苗字カナ}} {{名前カナ}}）様</p>

            <hr style="border: 1px solid #000000; margin-top: 10px; margin-bottom: 10px;">
            <p>注文詳細:</p>
            <p>{{商品データ}}</p>
            </br>
            <p>合計金額：{{小計}}</p>
            <hr style="border: 1px solid #000000; margin-top: 10px; margin-bottom: 10px;">
            </br>
            <p>商品は3営業日以内に発送いたします。</p>
            <p>ご利用いただきありがとうございました。</p>']);
            
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('mail_master')
            ->where('mail_master_id', 1)
            ->update(['mail_body' => 
            '{{苗字}} {{名前}}様\n\n"

            ご購入いただきありがとうございます。\n
            ご注文番号: {{注文ID}}\n\n
            注文詳細:\n
            {{商品データ}}\n
            <hr>\n\n
            合計金額：{{小計}}\n']);
    }
    
};
