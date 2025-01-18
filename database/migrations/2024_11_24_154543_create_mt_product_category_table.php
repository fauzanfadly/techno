<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMtProductCategoryTable extends Migration
{
    public function up()
    {
        Schema::create('mt_product_category', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mt_vendor_id');
            $table->unsignedBigInteger('image_id')->nullable();
            // $table->foreign('mt_vendor_id')->references('id')->on('vendors')->onDelete('restrict');
            // $table->foreign('image_id')->references('id')->on('mt_images_storage')->onDelete('restrict');
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mt_product_category');
    }
}