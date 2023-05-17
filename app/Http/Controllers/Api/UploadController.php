<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function uploadDecorImage(Request $request, $id, FileUploadService $fileUploadService): Response
    {
        $file = $request->file('image');
        $result = $fileUploadService->uploadDecorImage($file, $id);

        return response(compact('result'));
    }

    public function uploadFlowerImage(Request $request, $id, FileUploadService $fileUploadService): Response
    {
        $file = $request->file('image');
        $result = $fileUploadService->uploadFlowerImage($file, $id);

        return response(compact('result'));
    }
}
