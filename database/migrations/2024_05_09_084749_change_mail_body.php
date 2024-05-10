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
            ->update(['mail_body' => 
            '{{苗字}} {{名前}}様\n\n"

            ご購入いただきありがとうございます。\n
            ご注文番号: {{注文ID}}\n\n
            注文詳細:\n
            {{商品データ}}\n
            <hr>\n\n
            合計金額：{{小計}}\n']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('mail_master')
            ->where('mail_master_id', 1)
            ->update(['mail_body' => 
            'ご購入いただきありがとうございます。
            ご注文番号：xxxx

            ご注文明細メールを
            メールアドレスにお送りしました。']);
    }
};
