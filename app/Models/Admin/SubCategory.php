<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\ChildCategory;
use App\Models\Admin\Category;

class SubCategory extends Model
{
    use HasFactory;
    protected $guarded=[];


   public function category()
    {
    	return $this->belongsTo(Category::class);
    }
    public function child_category()
    {
    	return $this->hasMany(ChildCategory::class,'sub_category_id');
    }
}
