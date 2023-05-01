<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\BouquetDecorsRepository;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
class BouquetDecorsController extends Controller
{
    public function store(Request $request, BouquetDecorsRepository $bouquetDecorsRepository): Response
    {
        $data = $request->all();
        $bouquetDecors = $bouquetDecorsRepository->create($data);

        return response(compact('bouquetDecors'));
    }

    public function show(int $id, BouquetDecorsRepository $bouquetDecorsRepository): Response
    {
        $bouquetDecors = $bouquetDecorsRepository->find($id);

        return response(compact('bouquetDecors'));
    }

    public function destroy(int $id, BouquetDecorsRepository $bouquetDecorsRepository): Response
    {
        $bouquetDecors = $bouquetDecorsRepository->delete($id);

        return response(compact('bouquetDecors'));
    }
}
