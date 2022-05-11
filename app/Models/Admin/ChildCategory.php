<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\SubCategory;

class ChildCategory extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function subcategory()
    {
    	return $this->belongsTo(SubCategory::class,'sub_category_id');
    }

    
}
