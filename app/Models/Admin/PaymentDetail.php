<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Order;

class PaymentDetail extends Model
{
    use HasFactory;

    public function order()
    {
    	return $this->belongsTo(Order::class);
    }
}
