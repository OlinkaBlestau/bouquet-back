<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\DecorRepository;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class DecorController extends Controller
{
    public function index(Request $request, DecorRepository $decorRepository): Response
    {
        $decors = $decorRepository->paginate($request->get('limit'));

        return response(compact('decors'));
    }

    public function store(Request $request, DecorRepository $decorRepository): Response
    {
        $data = $request->all();
        $decor = $decorRepository->create($data);

        return response(compact('decor'));
    }

    public function show(int $id, DecorRepository $decorRepository): Response
    {
        $decor = $decorRepository->find($id);

        return response(compact('decor'));
    }

    public function update(Request $request, int $id, DecorRepository $decorRepository): Response
    {
        $data = $request->all();
        $decor = $decorRepository->update($data, $id);

        return response(compact('decor'));
    }

    public function destroy(int $id, DecorRepository $decorRepository): Response
    {
        $decor = $decorRepository->delete($id);

        return response(compact('decor'));
    }
}
