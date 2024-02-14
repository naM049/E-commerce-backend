<?php

use App\Enums\OrderStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up():void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->decimal('total');
            $table->enum('status', OrderStatus::values())->default(OrderStatus::UNPAID->value);
            $table->foreignId('user_id')->constrained()->nullOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    public function down():void
    {
        Schema::dropIfExists('orders');
    }
};
