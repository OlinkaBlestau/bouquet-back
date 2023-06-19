<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
<style>
    body { font-family: DejaVu Sans, serif; }
</style>
<div>
    <h2 style="text-align: center">Дякуємо за Ваше замовлення букету</h2>
    <p style="text-align: center; font-size: 20px">{{$order->bouquet()->first()->name}}</p>
    <div style="
    border: #000 solid 1px;
    border-radius: 10px;
    width: 550px;
    padding: 18px;
    "
    >
        @foreach ($order->bouquet()->first()->flowers as $flower )
            <div
                style="display: flex;
         font-size: 0.8vw;
         padding: 8px;
         margin-bottom: 2px;
         margin-top: 2px;
         ">
                <p><i>Назва квітки:</i> {{ $flower->name }}</p>
                <p style="margin-left: 70px"><i>Колір квітки:</i> {{ $flower->color }}</p>
                <p style="margin-left: 70px"><i>Ціна за одиницю:</i> {{ $flower->price }} грн.</p>
                {{--            <p style="margin-left: 70px"><strong>Seat</strong> : {{ $flower->pivot->bouquet_flowers_amount }}</p>--}}
            </div>
        @endforeach

        <hr>
        @foreach ($order->bouquet()->first()->decors as $decor )
            <div
                style="display: flex;
         font-size: 0.8vw;
         padding: 8px;
         margin-bottom: 2px;
         margin-top: 2px;
         ">
                <p><i>Назва декору:</i> : {{ $decor->name }}</p>
                <p style="margin-left: 70px"><i>Колір декору:</i> {{ $decor->color }}</p>
                <p style="margin-left: 70px"><i>Ціна за одиницю:</i> {{ $decor->price }}</p>
                <p style="margin-left: 70px"><i>Ціна за одиницю:</i> {{ $decor->price }}</p>
                {{--            <p style="margin-left: 70px"><strong>Seat</strong> : {{ $decor->pivot->bouquet_decors_amount }}</p>--}}

            </div>
        @endforeach
    </div>
    <div
        style="display: flex;
    border: #000 solid 1px;
    border-radius: 10px;
    width: 550px;
    margin-top: 15px;
    padding: 18px;
    font-size: 1vw">
        <p><strong>Total price:</strong> {{ $order->amount * $order->bouquet()->first()->total_price }} грн.</p>
    </div>

</div>
</body>
</html>
