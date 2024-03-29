<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = [
        'total',
        'user_id',
    ];

    protected $casts = [
      'status' => OrderStatus::class
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems():HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
