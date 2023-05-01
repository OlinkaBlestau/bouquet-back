<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\ShopRepository;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request, ShopRepository $shopRepository): Response
    {
        $shops = $shopRepository->paginate($request->get('limit'));

        return response(compact('shops'));
    }

    public function store(Request $request, ShopRepository $shopRepository): Response
    {
        $data = $request->all();
        $shop = $shopRepository->create($data);

        return response(compact('shop'));
    }

    public function show(int $id, ShopRepository $shopRepository): Response
    {
        $shop = $shopRepository->find($id);

        return response(compact('shop'));
    }

    public function update(Request $request, int $id, ShopRepository $shopRepository): Response
    {
        $data = $request->all();
        $shop = $shopRepository->update($data, $id);

        return response(compact('shop'));
    }

    public function destroy(int $id, ShopRepository $shopRepository): Response
    {
        $shop = $shopRepository->delete($id);

        return response(compact('shop'));
    }
}
