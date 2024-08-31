<?php
namespace App\Http\Traits;
 
use Illuminate\Http\UploadedFile;
use Modules\Site\Entities\File;
use Illuminate\Support\Facades\Storage;
 
trait UploadTrait
{
    protected function secureValidation($request) {
        $file = $request->file;
        // dd($file->getPathName());
        $fileContent = file_get_contents($file->getPathName());
        $message = [];
        $uploadOk = true;
        if (strpos($fileContent, '<?php') !== false) {
            $message[] = 'Bad file x1';
            $uploadOk = false; // ada jumpa <? dalam file // consider die cuba inject code dalam image, ni maksudnya php
        }
        
        if(strpos($fileContent, 'multipart/form-data') !== false) {
            $message[] = 'Bad file x2';
            $uploadOk = false;
        } 
        
        // if filename ada null byte. Jangan bagi system upload
        $replacestring = '/x00/';
        if ( preg_match($replacestring, $file->getClientOriginalName()) != 0) {
            $message[] = "Bad file x3";
            $uploadOk = false;
        }

        // make sure file name tak de .php
        if (strpos($file->getClientOriginalName(), '.php') !== false) {
            $message[] = "Bad file x4";
            $uploadOk = false;
        }
        
        return [
            'status' => $uploadOk,
            'message' => $message,
        ];
    }

    public function doUpload($request, $context) // Taking input image as parameter
    {
        $validation = $this->secureValidation($request);
        if ($validation['status'] == true) {
            $file = $request->file;
            $filenameWithExt = $file->getClientOriginalName();
            
            $ext = strtolower($file->getClientOriginalExtension()); // You can use also getClientOriginalName()
            $newName = $context . '_' . time().'.'.$ext;
            $path = $request->file->storeAs('',$newName,'upload');
            
            $objFile = new File();
            $objFile->context = $context;
            $objFile->ori_file_name = $filenameWithExt;
            $objFile->file_name = $newName;
            $objFile->mime_type = $file->getMimeType();
            $objFile->file_size = $file->getSize();
            $objFile->path = $path;
            $objFile->save();
            return [
                'status' => true, 
                'message' => $objFile->id, // Just return image
            ];
        }
        else {
            return $validation;
        }
    }

    public function deleteFile($id) {
        $file = File::find($id);
        Storage::disk('upload')->delete($file->path);
        $file->delete();
    }

    public function downloadFile($id) {
        $file = File::findOrFail($id);
        // $path = Storage::disk('upload')->get($file->path);  
        $path = storage_path().'/'.'app'.'/uploads/'.$file->path;
        if (file_exists($path))
            return response()->download($path, $file->ori_file_name);
        else 
            return false;
        // $response = response()->make($path);
        // $response->header("Content-Type", $file->mime_type);
        // return $response;     
    }

    public function readFile($id) {
        $file = File::findOrFail($id);
        $path = Storage::disk('upload')->get($file->path);  

        $response = response()->make($path);
        $response->header("Content-Type", $file->mime_type);
        return $response;     
    }
}