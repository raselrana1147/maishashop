<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\SubCategory;
class Category extends Model
{
    use HasFactory;


    public function sub_categories()
    {
    	return $this->hasMany(SubCategory::class);
    }
}
