<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Color;
use App\Models\Admin\Size;
use App\Models\Admin\Product;

class Stock extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function color()
    {
    	return $this->belongsTo(Color::class);
    }
    public function size()
    {
    	return $this->belongsTo(Size::class);
    }
    public function product()
    {
    	return $this->belongsTo(Product::class);
    }
}
