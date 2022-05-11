<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Product;

class Gallery extends Model
{
    use HasFactory;
    protected $guarded=[];
    
    public function product()
    {
    	return $this->belongsTo(Product::class);
    }
}
