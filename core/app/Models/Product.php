<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'info' => 'object'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class,'sub_category_id');
    }

    public function downloads()
    {
        return $this->hasMany(Download::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
