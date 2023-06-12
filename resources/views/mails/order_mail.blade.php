
<div>
    <h2 style="text-align: center">Дякуємо за Ваше замовлення</h2>
    <p>Order</p>
    <p>name</p>
    {{$order->bouquet()->first()->name}}
    @foreach ($order->bouquet()->first()->flowers as $flower )
        <div
            style="display: flex;
         border: 1px solid #4d7cbc;
         border-radius: 20px;
         font-size: 1.3vw;
         padding: 10px;
         margin-bottom: 10px;
         margin-top: 10px;
         ">
            <p><strong>Row</strong> : {{ $flower->name }}</p>
            <p style="margin-left: 70px"><strong>Seat</strong> : {{ $flower->price }}</p>
            <p style="margin-left: 70px"><strong>Seat</strong> : {{ $flower->color }}</p>
            <p style="margin-left: 70px"><strong>Seat</strong> : {{ $flower->pivot->bouquet_flowers_amount }}</p>
        </div>
    @endforeach
    @foreach ($order->bouquet()->first()->decors as $decor )
        <div
            style="display: flex;
         border: 1px solid #4d7cbc;
         border-radius: 20px;
         font-size: 1.3vw;
         padding: 10px;
         margin-bottom: 10px;
         margin-top: 10px;
         ">
            <p><strong>Row</strong> : {{ $decor->name }}</p>
            <p style="margin-left: 70px"><strong>Seat</strong> : {{ $decor->price }}</p>
            <p style="margin-left: 70px"><strong>Seat</strong> : {{ $decor->color }}</p>
            <p style="margin-left: 70px"><strong>Seat</strong> : {{ $decor->pivot->bouquet_decors_amount }}</p>
        </div>
    @endforeach
    <p>Total price</p>
    {{ $order->amount * $order->bouquet()->first()->total_price }}
</div>
