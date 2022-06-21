<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileFormat extends Model
{
    protected $guarded = ['id'];

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class,'sub_category_id');
    }
}
