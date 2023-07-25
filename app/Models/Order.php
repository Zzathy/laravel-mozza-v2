<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\OrderDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $primaryKey = 'order_id';

    public function orderDetail() {
        return $this->hasMany(OrderDetail::class);
    }

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_foreign', 'customer_id');
    }
}
