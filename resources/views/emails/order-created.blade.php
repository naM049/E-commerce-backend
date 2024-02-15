@component('mail::message')

    Dear {{ $order->user->name }},
    Thank you for placing an order with {{ config('app.name') }}. We are pleased to confirm the receipt of your order , dated {{ $order->created_at->format('d-m-Y') }}.
@component('mail::panel')

## Order Details

Order ID : **{{ $order->id }}**


@component('mail::table')

| # | Product | Quantity |  Price | Total |
| :-------------: | :-------------: | :-------------: | :-------------: | :-------------: | :-------------: |
@foreach($order->orderItems as $item)
| {{ $loop->iteration }} | {{ $item->product->name }} | {{ $item->quantity }} | {{ $item->unit_price }} | {{ $item->quantity * $item->unit_price }} |
@endforeach
@endcomponent
@endcomponent
<div style="text-align: right; font-weight: bold; font-size: large">Total : {{ $order->total }}</div>


@component('mail::button', ['url' =>  route("orders.show", $order->id) ])
View Order
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
