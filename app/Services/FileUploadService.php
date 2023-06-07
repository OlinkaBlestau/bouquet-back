<?php

namespace App\Services;

use App\Repositories\DecorRepository;
use App\Repositories\FlowerRepository;
use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    public function uploadDecorImage($file, $decorId): array
    {
        $decorRepository = app(DecorRepository::class);
        $decor = $decorRepository->find($decorId);

        $fileName = $file->getClientOriginalName();
        Storage::putFileAs('./public', $file, $fileName);

        $decor->img_path = $fileName;
        $decor->save();

        return [
            'name' => $fileName,
        ];
    }

    public function uploadFlowerImage($file, $flowerId): array
    {
        $flowerRepository = app(FlowerRepository::class);
        $flower = $flowerRepository->find($flowerId);

        $fileName = $file->getClientOriginalName();
        Storage::putFileAs('./public', $file, $fileName);

        $flower->img_path = $fileName;
        $flower->save();

        return [
            'name' => $fileName,
        ];
    }

}
