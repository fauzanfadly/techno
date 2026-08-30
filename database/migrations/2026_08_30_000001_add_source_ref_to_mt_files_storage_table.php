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
            // Penanda asal file saat migrasi legacy (Fase 4), dipakai untuk wiring FK entity di Fase 5.
            // Format: "series:74:img", "series:74:pdf", "vendor:2:img", "manufacture:1:img", "images:5".
            $table->string('source_ref')->nullable()->index()->after('folder_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mt_files_storage', function (Blueprint $table) {
            $table->dropIndex(['source_ref']);
            $table->dropColumn('source_ref');
        });
    }
};
