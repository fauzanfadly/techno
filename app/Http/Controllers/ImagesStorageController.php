<?php

namespace App\Http\Controllers;

use App\Models\MtImagesStorage;
use App\Services\UploadFileServices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class ImagesStorageController extends Controller
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
        $data = new MtImagesStorage();
        $data = $data->with([
            'mt_product',
            'mt_product_series',
            'mt_product_category',
            'mt_vendor',
            'mt_manufacture_type',
        ]);

        if (!empty($params['page']) && !empty($params['items_per_page'])) {
            $data = $data->paginate($params['items_per_page'], '*', 'page', $params['page']);
        } else {
            $data = $data->get();
        }

        return response()->success($data, "Imagess successfully fetched");
    }

    public function store()
    {
        $validator = Validator::make($this->request->all(), [
            'name' => 'required|string',
            'description' => 'nullable|string',
            'image_file' => 'required|file|mimes:jpg,jpeg,png',
        ]);

        if ($validator->fails()) {
            return response()->error($validator->errors()->first());
        }

        $data = $this->request->only([
            'name',
            'description',
        ]);

        try {
            $file = $this->request->file('image_file');
            $upload = $this->uploadFileServices->saveUploadImage($file);
            $data = array_merge($data, $upload);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return response()->error("Failed when saving uploaded image to storage, $message");
        }

        try {
            $create = MtImagesStorage::create($data);
            return response()->success($create, "Image successfully created");
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return response()->error("Failed when creating image, $message");
        }
    }

    public function show($id)
    {
        try {
            $data = MtImagesStorage::with([
                    'mt_product',
                    'mt_product_series',
                    'mt_product_category',
                    'mt_vendor',
                    'mt_manufacture_type',
                ])
                ->findOrFail($id);

            return response()->success($data, "Image '$id' successfully fetched");
        } catch (\Exception $e) {
            return response()->error("Image with id '$id' not found");
        }
    }

    public function update($id)
    {
        $params = [
            ...$this->request->all(),
            'id' => $id
        ];
        $validator = Validator::make($params, [
            'id' => 'required|exists:mt_product,id',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'image_file' => 'required|file|mimes:jpg,jpeg,png',
        ]);

        if ($validator->fails()) {
            return response()->error($validator->errors()->first());
        }

        $data = $this->request->only([
            'name',
            'description',
        ]);

        try {
            $update = MtImagesStorage::findOrFail($id);

            if ($this->request->hasFile('image_file')) {
                if ($update->image_path) {
                    Storage::disk('public')->delete($update->image_path);
                }

                $image_file = $this->request->file('image_file');
                $data['image_name'] = Carbon::now()->timestamp . '_' . $image_file->getClientOriginalName();
                $data['image_path'] = $image_file->storeAs('images/mt_product', $data['image_name'], 'public');
            }

            if ($this->request->hasFile('pdf_file')) {
                if ($update->pdf_file_path) {
                    Storage::disk('public')->delete($update->pdf_file_path);
                }

                $pdf_file = $this->request->file('pdf_file');
                $data['pdf_file_name'] = Carbon::now()->timestamp . '_' . $pdf_file->getClientOriginalName();
                $data['pdf_file_path'] = $pdf_file->storeAs('pdfs/mt_product', $data['pdf_file_name'], 'public');
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return response()->error("Failed when saving uploaded file to storage, $message");
        }

        try {
            $update->update($data);

            return response()->success($update, "Image '$id' successfully updated");
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return response()->error("Failed when updating product '$id', $message");
        }
    }

    public function destroy($id)
    {
        try {
            $delete = MtImagesStorage::findOrFail($id);
            $delete->delete();

            return response()->success(null, "Image '$id' deleted successful");
        } catch (\Exception $e) {
            return response()->error("Image with id '$id' not found");
        }
    }

    public function remove($id)
    {
        $params = $this->request->all();
        $type = $params['module_type'];
        $typeUpper = strtoupper($params['module_type']);
        $acceptedModuleType = [
            'PRODUCT' => 'mt_product',
            'PRODUCT SERIES' => 'mt_product_series',
            'PRODUCT CATEGORY' => 'mt_product_category',
            'VENDOR' => 'mt_vendor',
            'MANUFACTURE TYPE' => 'mt_manufacture_type',
        ];

        if (empty($acceptedModuleType[$typeUpper])) {
            return response()->error("Module type '$type' is not accepted");
        }

        try {
            $relationType = $acceptedModuleType[$typeUpper];
            $delete = MtImagesStorage::with($relationType)
                ->findOrFail($id);
        } catch (\Exception $e) {
            return response()->error("Image with id '$id' not found");
        }

        try {
            $delete->$relationType()
                ->where('id', $params['module_id'])
                ->update([ 'image_id' => null ]);

            return response()->success(null, "Image '$id' deleted successful");
        } catch (\Exception $e) {
            $moduleId = $params['module_id'];
            $message = $e->getMessage();
            return response()->error("Failed when removing image from '$type' at id '$moduleId', $message");
        }
    }
}