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
        Schema::table('mt_product_series', function (Blueprint $table) {
            // FK ke mt_files_storage untuk PDF datasheet series (sejajar mt_product.file_id).
            $table->unsignedBigInteger('file_id')->nullable()->after('image_id');
            // $table->foreign('file_id')->references('id')->on('mt_files_storage')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mt_product_series', function (Blueprint $table) {
            $table->dropColumn('file_id');
        });
    }
};
