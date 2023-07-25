<?php

namespace App\Models;

use App\Models\Manufacturer;
use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $primaryKey = 'product_id';

    public function manufacturer() {
        return $this->belongsTo(Manufacturer::class, 'manufacturer_foreign', 'manufacturer_id');
    }

    public function type() {
        return $this->belongsTo(Type::class, 'type_foreign', 'type_id');
    }

}
