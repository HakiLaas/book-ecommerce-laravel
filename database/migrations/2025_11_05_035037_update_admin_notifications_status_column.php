<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, we need to update existing enum values to match new string values
        DB::statement("UPDATE admin_notifications SET status = CASE 
            WHEN status = 'pending' THEN 'belum_diproses'
            WHEN status = 'processing' THEN 'sedang_disiapkan'
            WHEN status = 'completed' THEN 'transaksi_selesai'
            WHEN status = 'cancelled' THEN 'dibatalkan'
            ELSE status
        END");

        // Change column from enum to string
        Schema::table('admin_notifications', function (Blueprint $table) {
            $table->string('status')->default('belum_diproses')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Convert back to enum
        Schema::table('admin_notifications', function (Blueprint $table) {
            // Map new values back to old enum values
            DB::statement("UPDATE admin_notifications SET status = CASE 
                WHEN status = 'belum_diproses' THEN 'pending'
                WHEN status = 'sedang_disiapkan' THEN 'processing'
                WHEN status = 'transaksi_selesai' THEN 'completed'
                WHEN status = 'dibatalkan' THEN 'cancelled'
                ELSE 'pending'
            END");
            
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending')->change();
        });
    }
};
