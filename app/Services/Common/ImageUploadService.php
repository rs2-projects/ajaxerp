<?php

namespace App\Services\Common;

use Intervention\Image\Facades\Image;

class ImageUploadService
{
    public function store($image, $path='', $name=null, $type='webp'): array
    {
        try {
            if(!$this->validateType($type)) {
                throw new \Exception("Invalid Type!");
            }
            if($image == null) {
                throw new \Exception('Empty Image');
            }

            if($name === null) {
                $name = time() . rand(1000, 9999) .'.'. $type;
            }

            $full_path = storage_path().'/app/public/'.$path;
            $save_path = $full_path . '/' . $name;
            if (!file_exists($full_path)) {
                mkdir($full_path, 0777, true);
            }
            $iImage = Image::make($image);
            $iImage->encode($type, 70)->save($save_path);

            $return_path = 'storage/'.$path.'/'.$name;

        }catch (\Exception $exception){
            throw new \Exception($exception->getMessage());
        }

        return [
            'name' => $name,
            'path' => $return_path
        ];
    }

    public function validateType(string $type)
    {
        $availableTypes = [
            "jpg",
            "png",
            "gif",
            "tif",
            "bmp",
            "ico",
            "psd",
            "webp",
            "data-url",
        ];

        return in_array($type, $availableTypes);
    }
}
