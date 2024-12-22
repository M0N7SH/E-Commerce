<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // Define the one-to-many relationship
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
