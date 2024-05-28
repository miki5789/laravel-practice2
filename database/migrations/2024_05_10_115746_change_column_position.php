<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // カラムの順序を移動（primary_idをorder_idの前に移動）
        //DB::statement("ALTER TABLE order_product MODIFY COLUMN primary_id INT AUTO_INCREMENT PRIMARY KEY FIRST");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 例として、元の位置に戻すSQL文
        DB::statement("ALTER TABLE order_product MODIFY COLUMN primary_id INT AUTO_INCREMENT PRIMARY KEY");
    }
};
