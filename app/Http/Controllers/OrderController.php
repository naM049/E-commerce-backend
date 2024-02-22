<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Http\Resources\OrderResource;
use App\Mail\OrderCreatedMail;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Order::class, 'order');
    }

    public function index()
    {
        return OrderResource::collection(Order::with('orderItems')->paginate());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
//            'total' => ['required','numeric','gt:0'],
            'orders' => ['required', 'array'],
            'orders.*.product_id' => ['required', 'exists:products,id'],
            'orders.*.quantity' => ['required', 'numeric', 'gt:0'],
        ]);

        $total = 0;
        $orders = $data['orders'];
        foreach ($orders as $order) {
            $product = Product::find($order['product_id']);
            $total += $product->price * $order['quantity'];
        }


        $user = auth()->user()->id;

        DB::transaction(function () use ($total, $user, $orders) {
            $order = Order::create([
                'total' => $total,
                'user_id' => $user,
            ]);

            foreach ($orders as $order_item) {
                OrderItemController::store($order, $order_item);
            }

            Mail::to($order->user)->send(new OrderCreatedMail($order));
        });

        return new OrderResource(Order::where('user_id', $user)->with('orderItems')->latest()->first());
    }

    public function show(Order $order)
    {
        return new OrderResource($order);
    }

    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'total' => ['numeric', 'gt:0'],
            'status' => [Rule::enum(OrderStatus::class)]
        ]);

        $order->update($data);

        return new OrderResource($order);
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return response()->json();
    }
}
