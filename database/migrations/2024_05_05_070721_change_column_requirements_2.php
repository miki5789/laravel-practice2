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
            //$table->dropPrimary();
            //$table->integer('order_id')->change();
        });
        Schema::table('order_product', function (Blueprint $table) {
            //$table->bigIncrements('primary_id')->change();
            //$table->primary('primary_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_product', function (Blueprint $table) {
        });
    }
};
