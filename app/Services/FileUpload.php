<?php

namespace App\Services;

use Intervention\Image\Facades\Image;

class FileUpload
{
    /**
     * Universal file upload method
     * @param $request    The request object
     * @param $file_name  name of the file input field
     * @param $upload_dir upload directory
     * @return bool/string
     */
    public static function upload($request, $file_name, $upload_dir)
    {
        if ($request->hasFile($file_name)) {
            $file = $request->$file_name;
            $filename = time().'.'.$file->getClientOriginalExtension();
            $up_path = "uploads/".date('Y-m')."/$upload_dir/";
            $path = $file->move($up_path, $filename);
            if ($file->getError()) {
                $request->session()->flash('warning', $file->getErrorMessage());

                return false;
            }

            return $path;
        }
    }


    public static function uploadWithResize($request, $file_name, $upload_dir, $w = 250, $h = 250)
    {
        if ($request->hasFile($file_name)) {
            $file = $request->$file_name;
            $filename = time().'.'.$file->getClientOriginalExtension();
            $up_path = "uploads/".date('Y-m')."/$upload_dir/";
            $path = $file->move($up_path, $filename);
            if ($file->getError()) {
                $request->session()->flash('warning', $file->getErrorMessage());

                return false;
            }

            //image Resize
            $resizeImage = $path;
            $img = Image::make($resizeImage)->resize($w, $h, function($ratio) {
                $ratio->aspectRatio();
            });

            $img->save($resizeImage);

            return $path;
        }
    }

}
