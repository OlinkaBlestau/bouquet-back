<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\ShopRepository;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class ShopController extends Controller
{
    public function index(Request $request, ShopRepository $shopRepository): Response
    {
        $shops = $shopRepository->paginate($request->get('limit'));

        return response()->success(compact('shops'));
    }

    public function store(Request $request, ShopRepository $shopRepository): Response
    {
        $data = $request->all();
        $shop = $shopRepository->create($data);

        return response()->success(compact('shop'));
    }

    public function show(int $id, ShopRepository $shopRepository): Response
    {
        $shop = $shopRepository->show($id);

        return response()->success(compact('shop'));
    }

    public function update(Request $request, int $id, ShopRepository $shopRepository): Response
    {
        $data = $request->all();
        $shop = $shopRepository->update($data, $id);

        return response()->success(compact('shop'));
    }

    public function destroy(int $id, ShopRepository $shopRepository): Response
    {
        $shop = $shopRepository->delete($id);

        return response()->success(compact('shop'));
    }
}
