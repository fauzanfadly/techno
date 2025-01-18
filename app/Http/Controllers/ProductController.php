<?php

namespace App\Http\Controllers;

use App\Models\MtProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    private $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }


    public function index()
    {
        $params = $this->request->all();
        $data = new MtProduct();
        $data = $data->with('mt_product_series.mt_product_category.mt_vendor.mt_manufacture_type');

        if (!empty($params['page']) && !empty($params['items_per_page'])) {
            $data = $data->paginate($params['items_per_page'], '*', 'page', $params['page']);
        } else {
            $data = $data->get();
        }

        return response()->success($data, "Products successfully fetched");
    }

    public function store()
    {
        $validator = Validator::make($this->request->all(), [
            'mt_product_series_id' => 'required|exists:mt_product_series,id',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'image_file' => 'nullable|file|mimes:jpg,jpeg,png',
            'pdf_file' => 'nullable|file|mimes:pdf',
        ]);

        if ($validator->fails()) {
            return response()->error($validator->errors()->first());
        }

        $data = $this->request->only([
            'mt_product_series_id',
            'name',
            'description',
        ]);

        try {
            // Proses upload image_file jika ada
            if ($this->request->hasFile('image_file')) {
                $image_file = $this->request->file('image_file');
                $data['image_name'] = Carbon::now()->timestamp . '_' . $image_file->getClientOriginalName();
                $data['image_path'] = $image_file->storeAs('images/mt_product', $data['image_name'], 'public');
            }
    
            // Proses upload pdf_file jika ada
            if ($this->request->hasFile('pdf_file')) {
                $pdf_file = $this->request->file('pdf_file');
                $data['pdf_file_name'] = Carbon::now()->timestamp . '_' . $pdf_file->getClientOriginalName();
                $data['pdf_file_path'] = $pdf_file->storeAs('pdfs/mt_product', $data['pdf_file_name'], 'public');
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return response()->error("Failed when saving uploaded file to storage, $message");
        }

        try {
            $create = MtProduct::create($data);
            return response()->success($create, "Product successfully created");
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return response()->error("Failed when creating product, $message");
        }
    }

    public function show($id)
    {
        try {
            $data = MtProduct::with('mt_product_series.mt_product_category.mt_vendor.mt_manufacture_type')->findOrFail($id);
            return response()->success($data, "Product '$id' successfully fetched");
        } catch (\Exception $e) {
            return response()->error("Product with id '$id' not found");
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
            'mt_product_series_id' => 'required|exists:mt_product_series,id',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'image_file' => 'nullable|file|mimes:jpg,jpeg,png',
            'pdf_file' => 'nullable|file|mimes:pdf',
        ]);

        if ($validator->fails()) {
            return response()->error($validator->errors()->first());
        }


        $data = $this->request->only([
            'mt_product_series_id',
            'name',
            'description',
        ]);

        try {
            $update = MtProduct::findOrFail($id);

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

            return response()->success($update, "Product '$id' successfully updated");
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return response()->error("Failed when updating product '$id', $message");
        }
    }

    public function destroy($id)
    {
        try {
            $delete = MtProduct::findOrFail($id);
            $delete->delete();

            return response()->success(null, "Product '$id' deleted successful");
        } catch (\Exception $e) {
            return response()->error("Product with id '$id' not found");
        }
    }
}