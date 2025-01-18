<?php

namespace App\Http\Controllers;

use App\Models\MtFilesStorage;
use App\Services\UploadFileServices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class FilesStorageController extends Controller
{
    private $request;
    private $uploadFileServices;

    public function __construct(
        Request $request,
        UploadFileServices $uploadFileServices,
    ) {
        $this->request = $request;
        $this->uploadFileServices = $uploadFileServices;
    }


    public function index()
    {
        $params = $this->request->all();
        $data = new MtFilesStorage();
        $data = $data->with('mt_product');

        if (!empty($params['page']) && !empty($params['items_per_page'])) {
            $data = $data->paginate($params['items_per_page'], '*', 'page', $params['page']);
        } else {
            $data = $data->get();
        }

        return response()->success($data, "Files successfully fetched");
    }

    public function store()
    {
        $validator = Validator::make($this->request->all(), [
            'name' => 'required|string',
            'description' => 'nullable|string',
            'pdf_file' => 'required|file|mimes:pdf',
        ]);

        if ($validator->fails()) {
            return response()->error($validator->errors()->first());
        }

        $data = $this->request->only([
            'name',
            'description',
        ]);

        try {
            $file = $this->request->file('pdf_file');
            $upload = $this->uploadFileServices->saveUploadFile($file);
            $data = array_merge($data, $upload);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return response()->error("Failed when saving uploaded image to storage, $message");
        }

        try {
            $create = MtFilesStorage::create($data);
            return response()->success($create, "Image successfully created");
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return response()->error("Failed when creating image, $message");
        }
    }

    public function show($id)
    {
        try {
            $data = MtFilesStorage::with('mt_product')->findOrFail($id);
            return response()->success($data, "File '$id' successfully fetched");
        } catch (\Exception $e) {
            return response()->error("File with id '$id' not found");
        }
    }

    public function update($id)
    {
        $params = [
            ...$this->request->all(),
            'id' => $id
        ];
        $validator = Validator::make($params, [
            'id' => 'required|exists:mt_files_storage,id',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'pdf_file' => 'required|file|mimes:jpg,jpeg,png',
        ]);

        if ($validator->fails()) {
            return response()->error($validator->errors()->first());
        }

        $data = $this->request->only([
            'name',
            'description',
        ]);

        try {
            $update = MtFilesStorage::findOrFail($id);

            if ($this->request->hasFile('image_file')) {
                if ($update->image_path) {
                    Storage::disk('public')->delete($update->image_path);
                }

                $image_file = $this->request->file('image_file');
                $data['image_name'] = Carbon::now()->timestamp . '_' . $image_file->getClientOriginalName();
                $data['image_path'] = $image_file->storeAs('upload/files', $data['image_name'], 'public');
            }

            if ($this->request->hasFile('pdf_file')) {
                if ($update->pdf_file_path) {
                    Storage::disk('public')->delete($update->pdf_file_path);
                }

                $pdf_file = $this->request->file('pdf_file');
                $data['pdf_file_name'] = Carbon::now()->timestamp . '_' . $pdf_file->getClientOriginalName();
                $data['pdf_file_path'] = $pdf_file->storeAs('upload/files', $data['pdf_file_name'], 'public');
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return response()->error("Failed when saving uploaded file to storage, $message");
        }

        try {
            $update->update($data);

            return response()->success($update, "File '$id' successfully updated");
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return response()->error("Failed when updating file '$id', $message");
        }
    }

    public function destroy($id)
    {
        try {
            $delete = MtFilesStorage::findOrFail($id);
            $delete->delete();

            return response()->success(null, "File '$id' deleted successful");
        } catch (\Exception $e) {
            return response()->error("File with id '$id' not found");
        }
    }
}