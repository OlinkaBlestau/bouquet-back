<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\BouquetRepository;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class BouquetController extends Controller
{
    public function index(Request $request, BouquetRepository $bouquetRepository): Response
    {
        $bouquets = $bouquetRepository->paginate($request->get('limit'));

        return response(compact('bouquets'));
    }

    public function store(Request $request, BouquetRepository $bouquetRepository): Response
    {
        $data = $request->all();
        $bouquet = $bouquetRepository->create($data);

        return response(compact('bouquet'));
    }

    public function show(int $id, BouquetRepository $bouquetRepository): Response
    {
        $bouquet = $bouquetRepository->find($id);

        return response(compact('bouquet'));
    }

    public function update(Request $request, int $id, BouquetRepository $bouquetRepository): Response
    {
        $data = $request->all();
        $bouquet = $bouquetRepository->update($data, $id);

        return response(compact('bouquet'));
    }

    public function destroy(int $id, BouquetRepository $bouquetRepository): Response
    {
        $bouquet = $bouquetRepository->delete($id);

        return response(compact('bouquet'));
    }
}
