<?php

namespace App\Http\Controllers;

use App\Http\Traits\UploadTrait;
use Illuminate\Http\Request;

class FileController extends Controller
{
    use UploadTrait;

    public function read($id) {
        return $this->readFile($id);
    }

    public function download($id) {
        $fileResponse = $this->downloadFile($id);
        if (!$fileResponse) {
            return back()->with('toast_error', 'File not found');
        }

        return $fileResponse;
    }
}
