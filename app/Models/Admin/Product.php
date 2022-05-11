<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Category;
use App\Models\Admin\SubCategory;
use App\Models\Admin\ChildCategory;
use App\Models\Admin\Gallery;
use App\Models\Admin\Stock;
use App\Models\Admin\Brand;

class Product extends Model
{
    use HasFactory;

    public function category()
    {
    	return $this->belongsTo(Category::class);
    }

     public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function sub_category()
    {
    	return $this->belongsTo(SubCategory::class);
    }

    public function child_category()
    {
    	return $this->belongsTo(ChildCategory::class);
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

    public function stocks()
    {
         return $this->hasMany(Stock::class);
    }
}
