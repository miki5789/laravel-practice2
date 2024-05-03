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
        Schema::table('order_product', function (Blueprint $table) {
            // 1. 既存の主キーを削除
            $table->dropPrimary();
            // 2. 既存のカラムに主キーを付与
            $table->primary('primary_id');
            // 3. order_id列の定義を変更
            //$table->bigInteger('order_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_product', function (Blueprint $table) {
            // 1. 新しい主キーを削除
            $table->dropPrimary('primary_id');
            // 2. order_id列の定義を元に戻す
            $table->bigIncrements('order_id')->change();
        });
    }
};
