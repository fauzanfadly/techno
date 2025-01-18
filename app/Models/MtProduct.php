<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MtProduct extends Model
{
    use HasFactory;

    protected $table = 'mt_product';
    protected $guarded = [];


    public function mt_product_series()
    {
        return $this->belongsTo(MtProductSeries::class, 'mt_product_series_id', 'id');
    }

    public function image()
    {
        return $this->belongsTo(MtImagesStorage::class, 'image_id', 'id');
    }

    public function file()
    {
        return $this->belongsTo(MtFilesStorage::class, 'file_id', 'id');
    }
}