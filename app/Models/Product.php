<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function type() {
        return $this->hasMany(Type::class, "type_id", "id");
    }

    public function manufacturer() {
        return $this->hasMany(Manufacturer::class, "manufacturer_id", "id");
    }
}
