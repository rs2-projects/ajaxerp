<?php

namespace App\Services\Common;

class FileUploadService
{
    public function store($file, $path='', $name=null): array
    {
        try {
            if($file == null) {
                throw new \Exception('Empty File!');
            }

            if($name === null) {
                $name = time() . rand(1000, 9999) .'.'. $file->getClientOriginalExtension();
            }

            $full_path = storage_path().'/app/public/'.$path;
            $save_path = $full_path . '/' . $name;
            if (!file_exists($full_path)) {
                mkdir($full_path, 0777, true);
            }
            $file->move($full_path, $name);

            $return_path = 'storage/'.$path.'/'.$name;

        }catch (\Exception $exception){
            throw new \Exception($exception->getMessage());
        }

        return [
            'name' => $name,
            'path' => $return_path
        ];
    }

    public function update($file, $path='', $old_file_path='', $name=null): array
    {
        try {
            if($file == null) {
                throw new \Exception('Empty File');
            }

            if($name === null) {
                $name = time() . rand(1000, 9999) .'.'. $file->getClientOriginalExtension();
            }

            $full_path = storage_path().'/app/public/'.$path;
            $save_path = $full_path . '/' . $name;
            if (!file_exists($full_path)) {
                mkdir($full_path, 0777, true);
            }
            $file->move($full_path, $name);

            $return_path = 'storage/'.$path.'/'.$name;

            if($old_file_path != null && $old_file_path != ''){
                $old_file_path = str_replace('storage/','',$old_file_path);
                $old_file_path = storage_path().'/app/public/'.$old_file_path;
                if(file_exists($old_file_path)){
                    unlink($old_file_path);
                }
            }

        }catch (\Exception $exception){
            throw new \Exception($exception->getMessage());
        }

        return [
            'name' => $name,
            'path' => $return_path
        ];
    }
}
