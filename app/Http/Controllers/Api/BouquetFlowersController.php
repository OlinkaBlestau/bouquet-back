<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\BouquetFlowersRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Request;

class BouquetFlowersController extends Controller
{
    public function store(Request $request, BouquetFlowersRepository $bouquetFlowersRepository): Response
    {
        $data = $request->all();
        $bouquetFlowers = $bouquetFlowersRepository->create($data);

        return response()->success(compact('bouquetFlowers'));
    }

    public function show(int $id, BouquetFlowersRepository $bouquetFlowersRepository): Response
    {
        $bouquetFlowers = $bouquetFlowersRepository->find($id);

        return response()->success(compact('bouquetFlowers'));
    }

    public function destroy(int $id, BouquetFlowersRepository $bouquetFlowersRepository): Response
    {
        $bouquetFlowers = $bouquetFlowersRepository->delete($id);

        return response()->success(compact('bouquetFlowers'));
    }
}
