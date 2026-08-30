<?php

namespace App\Services;

use App\Exceptions\CustomError;
use Carbon\Carbon;


class UploadFileServices
{
    private $imagePath;
    private $filePath;

    function __construct()
    {
        $this->imagePath = "upload/images";
        $this->filePath = "upload/files";
    }


    /**
     * Get the user associated with the UploadFileServices
     *
     * @param \Illuminate\Http\UploadedFile | \Illuminate\Http\UploadedFile[] | array $file 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function saveUploadImage($file)
    {
        $data = [];
        try {
            // Generate a unique image name
            $data['image_name'] = Carbon::now()->timestamp . '_' . $file->getClientOriginalName();

            // Store the image and get the path
            $data['image_path'] = $file->storeAs($this->imagePath, $data['image_name'], 'public');

            // Capture additional metadata
            $data['image_extension'] = $file->getClientOriginalExtension();
            $data['image_size'] = $file->getSize();
            $data['image_mime_type'] = $file->getClientMimeType();
        } catch (\Exception $e) {
            $message = $e->getMessage();
            throw new CustomError("Failed when saveUploadImage, $message");
        }

        return $data;
    }

    /**
     * Get the user associated with the UploadFileServices
     *
     * @param \Illuminate\Http\UploadedFile | \Illuminate\Http\UploadedFile[] | array $file 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function saveUploadFile($file, ?string $folderPath = null)
    {
        $data = [];
        try {
            // Generate a unique file name
            $data['file_name'] = Carbon::now()->timestamp . '_' . $file->getClientOriginalName();

            // Mirror the folder tree on disk: upload/files/<folderPath>/<file_name>
            $dir = $folderPath ? $this->filePath . '/' . $folderPath : $this->filePath;

            // Store the file and get the path
            $data['file_path'] = $file->storeAs($dir, $data['file_name'], 'public');

            // Capture additional metadata
            $data['file_extension'] = $file->getClientOriginalExtension();
            $data['file_size'] = $file->getSize();
            $data['file_mime_type'] = $file->getClientMimeType();
        } catch (\Exception $e) {
            $message = $e->getMessage();
            throw new CustomError("Failed when saveUploadFile, $message");
        }

        return $data;
    }
}
