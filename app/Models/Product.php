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

    public function manufacturer() {
        return $this->belongsTo(Manufacturer::class);
    }

    public function type() {
        return $this->belongsTo(Type::class);
    }

}
