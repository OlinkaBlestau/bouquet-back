<?php

namespace App\Services;

use App\Mail\OrderMail;
use App\Models\Decor;
use App\Models\Flower;
use App\Models\Order;
use App\Models\User;
use App\Repositories\OrderRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Prettus\Validator\Exceptions\ValidatorException;

class StripeService
{
    public function purchase($data): Order
    {
        $user = User::find($data["bouquet"]->user_id);
        $paymentMethod = $data['payment_method'];
        $totalMoney = $data["bouquet"]->total_price;
        $orderRepository = app(OrderRepository::class);

        DB::beginTransaction();
        try {
            foreach ($data["bouquet"]->flowers as $flower) {
                $existedFlower = Flower::find($flower->id);
                if ($flower->pivot->bouquet_flowers_amount > $existedFlower->storage_flowers_amount) {
                    throw new \Exception("Not enough flower $flower->id at system", 422);
                }

                $existedFlower->storage_flowers_amount -= $flower->pivot->bouquet_flowers_amount;
                $existedFlower->save();
            }

            foreach ($data["bouquet"]->decors as $decor) {
                $existedDecor = Decor::find($decor->id);
                if ($decor->pivot->bouquet_decors_amount > $existedDecor->storage_decors_amount) {
                    throw new \Exception("Not enough decor $decor->id at system", 422);
                }

                $existedDecor->storage_decors_amount -= $decor->pivot->bouquet_decors_amount;
                $existedDecor->save();
            }

            $order = $orderRepository->create([
                'user_id' => $user->id,
                'amount' => $data["bouquet"]->amount,
                'bouquet_id' => $data["bouquet"]->id,
                'shop_id' => $data["shop_id"],
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw new ValidatorException($e->getMessageBag());
        }

        $user->charge(
            $totalMoney * 100, $paymentMethod
        );

        $pdf = Pdf::loadView('pdfs.order_mail', ['order' => $order]);
        Mail::to(env("MAIL_TO"))->send(new OrderMail($order, $pdf->output()));

        return $order;
    }
}
