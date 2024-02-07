<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'units_in_stock',
        'category_id',
    ];

    protected $casts = [
        'price' => 'float',
        'units_in_stock' => 'int'
    ];

    public function category():BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
