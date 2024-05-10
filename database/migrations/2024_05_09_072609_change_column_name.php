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
        Schema::table('mail_master', function (Blueprint $table) {
            $table->renameColumn('delete_flag', 'delete_flg');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mail_master', function (Blueprint $table) {
            $table->renameColumn('delete_flg', 'delete_flag');
        });
    }
};
