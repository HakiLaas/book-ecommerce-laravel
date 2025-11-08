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
        Schema::create('admin_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('transaction_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('type')->default('order_confirmation'); // order_confirmation, payment_confirmation, etc.
            $table->string('title');
            $table->text('message');
            $table->json('data')->nullable(); // Additional data like cart items, user info
            $table->string('status')->default('belum_diproses')->comment('belum_diproses, sedang_disiapkan, transaksi_selesai, dibatalkan, pending, processing, completed, cancelled');
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_notifications');
    }
};
