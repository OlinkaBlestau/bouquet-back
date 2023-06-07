<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\OrderMail;
use App\Models\User;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class StripeController extends Controller
{
    public function getPaymentIntent($id)
    {
        $user = User::find($id);

        return $user->createSetupIntent();
    }

    public function purchase(Request $request, StripeService $stripeService): Response
    {
        $data["payment_method"] = $request->input("payment_method");
        $data["shop_id"] = $request->input("shop_id");
        $data['bouquet'] = json_decode($request->input("bouquet"));
        $result = $stripeService->purchase($data);

        return response($result);
    }
}
