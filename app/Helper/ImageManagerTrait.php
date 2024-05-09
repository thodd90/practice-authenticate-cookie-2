<?php
namespace App\Helper;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

trait ImageManagerTrait{
    public function upload(object $file, string $path = 'images')
    {
        $fileName = time().$file->getClientOriginalName();
        $file->storeAs($path, $fileName);

        return [
            'name'=> $fileName,
            'type'=> $file->getClientMimeType(),
            'fileSize' => $this->getFileSize($file),
            'filePath' => 'storage/'.$path.'/'.$fileName,
        ];
    }

    private function getFileSize(object $file)
    {
        $size = $file->getSize();
        $suffixes = [' bytes', ' KB', ' MB', ' GB', ' TB'];
        $base = log($size) / log(1024);

        return round(pow(1024, ($base) - floor($base)), 2) . $suffixes[floor($base)];
    }
}
