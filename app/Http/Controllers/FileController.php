<?php

namespace App\Http\Controllers;

use App\Helper\ImageManagerTrait;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class FileController extends Controller
{
    use ImageManagerTrait;

    public function __construct(){

    }

    public function uploadFile(Request $request){
        $file = $request->file('file');
        if(!$file) throw new BadRequestHttpException();

        $savedFile = $this->upload($file);

        return response()->json([
            'message' => 'Upload file success',
            'file' => $savedFile,
        ]);
    }
}
