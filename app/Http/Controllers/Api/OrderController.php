<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request, OrderRepository $orderRepository): Response
    {
        $orders = $orderRepository->paginate($request->get('limit'));

        return response(compact('orders'));
    }

    public function store(Request $request, OrderRepository $orderRepository): Response
    {
        $data = $request->all();
        $order = $orderRepository->create($data);

        return response(compact('order'));
    }

    public function show(int $id, OrderRepository $orderRepository): Response
    {
        $order = $orderRepository->find($id);

        return response(compact('order'));
    }

    public function update(Request $request, int $id, OrderRepository $orderRepository): Response
    {
        $data = $request->all();
        $order = $orderRepository->update($data, $id);

        return response(compact('order'));
    }

    public function destroy(int $id, OrderRepository $orderRepository): Response
    {
        $order = $orderRepository->delete($id);

        return response(compact('order'));
    }
}
