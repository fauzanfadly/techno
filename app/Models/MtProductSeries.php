<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MtProductSeries extends Model
{
    use HasFactory;

    protected $table = 'mt_product_series';
    protected $guarded = [];

    protected $casts = [
        'no_pdf' => 'boolean',
    ];


    public function mt_product_category()
    {
        return $this->belongsTo(MtProductCategory::class, 'mt_product_category_id', 'id');
    }

    public function mt_product()
    {
        return $this->hasMany(MtProduct::class, 'mt_product_series_id', 'id');
    }

    public function image()
    {
        return $this->belongsTo(MtImagesStorage::class, 'image_id', 'id');
    }
}