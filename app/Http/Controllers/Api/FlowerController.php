<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\FlowerRepository;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class FlowerController extends Controller
{
    public function index(Request $request, FlowerRepository $flowerRepository): Response
    {
        $flowers = $flowerRepository->paginate($request->get('limit'));

        return response(compact('flowers'));
    }

    public function store(Request $request, FlowerRepository $flowerRepository): Response
    {
        $data = $request->all();
        $flower = $flowerRepository->create($data);

        return response(compact('flower'));
    }

    public function show(int $id, FlowerRepository $flowerRepository): Response
    {
        $flower = $flowerRepository->find($id);

        return response(compact('flower'));
    }

    public function update(Request $request, int $id, FlowerRepository $flowerRepository): Response
    {
        $data = $request->all();
        $flower = $flowerRepository->update($data, $id);

        return response(compact('flower'));
    }

    public function destroy(int $id, FlowerRepository $flowerRepository): Response
    {
        $flower = $flowerRepository->delete($id);

        return response(compact('flower'));
    }
}
