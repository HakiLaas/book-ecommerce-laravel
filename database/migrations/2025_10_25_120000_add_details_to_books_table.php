<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->string('format')->nullable()->after('price'); // digital/print
            $table->unsignedInteger('pages')->nullable()->after('format');
            $table->string('dimensions')->nullable()->after('pages');
            $table->string('language')->nullable()->after('dimensions');
            $table->string('publisher')->nullable()->after('language');
            $table->text('author_info')->nullable()->after('publisher');
            $table->string('category')->nullable()->after('author_info');
            $table->string('tags')->nullable()->after('category'); // comma-separated
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn([
                'format', 'pages', 'dimensions', 'language', 'publisher', 'author_info', 'category', 'tags'
            ]);
        });
    }
};