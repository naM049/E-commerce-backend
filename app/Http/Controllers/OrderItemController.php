<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderItemResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class OrderItemController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(OrderItem::class, 'order_item');
    }
    public function index()
    {
        return OrderItemResource::collection(OrderItem::paginate());
    }

    public static function store(Order $order, array $order_item)
    {
        Validator::make($order_item,[
            'product_id' => ['required','exists:products,id'],
            'quantity' => ['required','numeric','gt:0'],
        ]);
        $product = Product::find($order_item['product_id']);
        if ($product->units_in_stock < $order_item['quantity']) {
            abort(422, 'Not enough units in stock');
        }

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $order_item['quantity'],
            'unit_price' => $product->price
        ]);

        $product->decrement('units_in_stock', $order_item['quantity']);
    }

    public function show(OrderItem $order_item)
    {
        return new OrderItemResource($order_item);
    }

    public function update(Request $request, OrderItem $order_item)
    {
        $data = $request->validate([
           'quantity' =>  ['required','numeric','gt:0'],
        ]);

        $order_item->update($data);

        return new OrderItemResource($order_item);
    }

    public function destroy(OrderItem $order_item)
    {
        $order_item->delete();

        return response()->json();
    }
}
