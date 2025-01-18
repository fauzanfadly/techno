<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MtImagesStorage extends Model
{
    use HasFactory;

    protected $table = 'mt_images_storage';
    protected $guarded = [];


    public function mt_product()
    {
        return $this->hasMany(MtProduct::class, 'image_id', 'id');
    }

    public function mt_product_series()
    {
        return $this->hasMany(MtProductSeries::class, 'image_id', 'id');
    }

    public function mt_product_category()
    {
        return $this->hasMany(MtProductCategory::class, 'image_id', 'id');
    }

    public function mt_vendor()
    {
        return $this->hasMany(MtVendor::class, 'image_id', 'id');
    }

    public function mt_manufacture_type()
    {
        return $this->hasMany(MtManufactureType::class, 'image_id', 'id');
    }
}
