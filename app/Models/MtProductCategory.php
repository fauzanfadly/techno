<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MtProductCategory extends Model
{
    use HasFactory;

    protected $table = 'mt_product_category';
    protected $guarded = [];


    public function mt_vendor()
    {
        return $this->belongsTo(MtVendor::class, 'mt_vendor_id', 'id');
    }

    public function mt_product_series()
    {
        return $this->hasMany(MtProductSeries::class, 'mt_product_category_id', 'id');
    }

    public function image()
    {
        return $this->belongsTo(MtFilesStorage::class, 'image_id', 'id');
    }
}