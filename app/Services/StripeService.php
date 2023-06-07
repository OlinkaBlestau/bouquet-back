<?php

namespace App\Services;

use App\Mail\OrderMail;
use App\Models\Order;
use App\Models\User;
use App\Repositories\OrderRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

class StripeService
{
    public function purchase($data): Order
    {
        $user = User::find($data["bouquet"]->user_id);
        $paymentMethod = $data['payment_method'];
        $totalMoney = $data["bouquet"]->total_price;
        $orderRepository = app(OrderRepository::class);

        $user->charge(
            $totalMoney * 100, $paymentMethod
        );

        $orderData = [
            'user_id' => $user->id,
            'amount' => $data["bouquet"]->amount,
            'bouquet_id' => $data["bouquet"]->id,
            'shop_id' => $data["shop_id"],
        ];


        $order = $orderRepository->create($orderData);
        $pdf = Pdf::loadView('pdfs.order_mail', ['order' => $order]);
        Mail::to(env("MAIL_TO"))->send(new OrderMail($order, $pdf->output()));

        return $order;
    }
}
