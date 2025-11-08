<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('receiver_name')->nullable()->after('total_price');
            $table->string('phone')->nullable()->after('receiver_name');
            $table->text('address')->nullable()->after('phone');
            $table->string('payment_method')->nullable()->after('address');
            $table->string('status')->default('pending')->after('payment_method');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['receiver_name','phone','address','payment_method','status']);
        });
    }
};