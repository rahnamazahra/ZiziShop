<?php

use App\Models\{Province, City, File};

if(!defined('STATIC_DIR')){
    define('STATIC_DIR', sprintf('%s/../../public/upload/',__DIR__));
}

if (! function_exists('getProvinces'))
{
    function getProvinces()
    {
        $provinces = Province::all();
        return $provinces;
    }
}

if (! function_exists('getCities'))
{
    function getCities()
    {
        $cities = City::all();
        return $cities;
    }
}

if(! function_exists('uploadFile'))
{
    function uploadFile($storage_disk, array $files, array $data = [])
    {
        foreach ($files as $file)
        {
            $fileName = time().'_'.$file->getClientOriginalName();
            $path     = $file->storeAs($storage_disk, $fileName);

            File::create([
                'file_name'     => $fileName,
                'path'          => $path,
                'size'          => $file->getSize(),
                'mime_type'     => $file->getClientMimeType(),
                'fileable_id'   => $data['fileable_id'],
                'fileable_type' => $data['fileable_type'],
            ]);
        }

        return true;
    }

}

if(! function_exists('purge'))
{
    function purge($filePath)
    {
        if($filePath)
        {
            $file_path = sprintf('%s%s', STATIC_DIR, $filePath);

            if(file_exists($file_path))
            {
                unlink($file_path);

                return true;
            }
        }
    }
}
