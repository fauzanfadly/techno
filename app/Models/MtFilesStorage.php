<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MtFilesStorage extends Model
{
    use HasFactory;

    protected $table = 'mt_files_storage';
    protected $guarded = [];


    public function mt_product()
    {
        return $this->hasMany(MtProduct::class, 'file_id', 'id');
    }
}
