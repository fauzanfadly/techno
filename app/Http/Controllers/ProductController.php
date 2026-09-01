<?php

namespace App\Http\Controllers;

use App\Models\MtProduct;
use Illuminate\Http\Request;
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
        $data = $data->with([
            'mt_product_series.mt_product_category.mt_vendor.mt_manufacture_type',
            'image',
            'file',
        ]);

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
            'image_id' => 'nullable|exists:mt_files_storage,id',
            'file_id' => 'nullable|exists:mt_files_storage,id',
        ]);

        if ($validator->fails()) {
            return response()->error($validator->errors()->first());
        }

        $data = $this->request->only([
            'mt_product_series_id',
            'name',
            'description',
            'image_id',
            'file_id',
        ]);

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
            $data = MtProduct::with([
                    'mt_product_series.mt_product_category.mt_vendor.mt_manufacture_type',
                    'image',
                    'file',
                ])
                ->findOrFail($id);

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
            'image_id' => 'nullable|exists:mt_files_storage,id',
            'file_id' => 'nullable|exists:mt_files_storage,id',
        ]);

        if ($validator->fails()) {
            return response()->error($validator->errors()->first());
        }

        $data = $this->request->only([
            'mt_product_series_id',
            'name',
            'description',
            'image_id',
            'file_id',
        ]);

        try {
            $update = MtProduct::findOrFail($id);
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
