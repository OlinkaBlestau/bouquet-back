<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\BouquetDecorsRepository;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class BouquetDecorsController extends Controller
{
    public function store(Request $request, BouquetDecorsRepository $bouquetDecorsRepository): Response
    {
        $data = $request->all();
        $bouquetDecors = $bouquetDecorsRepository->create($data);

        return response()->success(compact('bouquetDecors'));
    }

    public function show(int $id, BouquetDecorsRepository $bouquetDecorsRepository): Response
    {
        $bouquetDecors = $bouquetDecorsRepository->find($id);

        return response()->success(compact('bouquetDecors'));
    }

    public function destroy(int $id, BouquetDecorsRepository $bouquetDecorsRepository): Response
    {
        $bouquetDecors = $bouquetDecorsRepository->delete($id);

        return response()->success(compact('bouquetDecors'));
    }
}
