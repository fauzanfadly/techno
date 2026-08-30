<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MtVendor extends Model
{
    use HasFactory;

    protected $table = 'mt_vendor';
    protected $guarded = [];


    public function mt_manufacture_type()
    {
        return $this->belongsTo(MtManufactureType::class, 'mt_manufacture_type_id', 'id');
    }

    public function mt_product_category()
    {
        return $this->hasMany(MtProductCategory::class, 'mt_vendor_id', 'id');
    }

    public function image()
    {
        return $this->belongsTo(MtFilesStorage::class, 'image_id', 'id');
    }
}