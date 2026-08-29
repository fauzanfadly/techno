<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MtFolder extends Model
{
    use HasFactory;

    protected $table = 'mt_folders';
    protected $guarded = [];


    public function parent()
    {
        return $this->belongsTo(MtFolder::class, 'parent_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(MtFolder::class, 'parent_id', 'id');
    }

    public function files()
    {
        return $this->hasMany(MtFilesStorage::class, 'folder_id', 'id');
    }
}
