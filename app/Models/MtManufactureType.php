<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MtManufactureType extends Model
{
    use HasFactory;

    protected $table = 'mt_manufacture_type';
    protected $guarded = [];


    public function mt_vendor()
    {
        return $this->hasMany(MtVendor::class, 'mt_manufacture_type_id', 'id');
    }

    public function image()
    {
        return $this->belongsTo(MtFilesStorage::class, 'image_id', 'id');
    }
}