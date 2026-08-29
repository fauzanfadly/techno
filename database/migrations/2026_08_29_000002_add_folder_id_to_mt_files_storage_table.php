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
        Schema::table('mt_files_storage', function (Blueprint $table) {
            $table->unsignedBigInteger('folder_id')->nullable()->after('id');
            // $table->foreign('folder_id')->references('id')->on('mt_folders')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mt_files_storage', function (Blueprint $table) {
            $table->dropColumn('folder_id');
        });
    }
};
