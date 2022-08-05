<?php
 
namespace App\Traits;
 
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Carbon\Carbon;

trait FileManagerTrait 
{
    public function storeFile(UploadedFile $file, $folder)
    {
        $fileName = Carbon::now()->timestamp."_".uniqid();
        $ext = $file->getClientOriginalExtension();
        Storage::disk('local')->putFileAs($folder, $file, $fileName.'.'.$ext);
    
        return $fileName.'.'.$ext;
    }

    public function getFile($fileName, $folderName)
    {
        if($fileName){
            return url('storage/'.$folderName.'/'.$fileName);
        }else{
            return null;
        }
    }
}