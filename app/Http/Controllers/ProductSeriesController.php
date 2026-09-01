<?php

namespace App\Http\Controllers;

use App\Models\MtProductSeries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ProductSeriesController extends Controller
{
    private $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }


    public function index()
    {
        $params = $this->request->all();
        $data = new MtProductSeries();
        $data = $data->with([
            'mt_product_category.mt_vendor.mt_manufacture_type',
            'image',
        ]);

        if (!empty($params['page']) && !empty($params['items_per_page'])) {
            $data = $data->paginate($params['items_per_page'], '*', 'page', $params['page']);
        } else {
            $data = $data->get();
        }

        return response()->success($data, "Product series successfully fetched");
    }

    public function store()
    {
        $validator = Validator::make($this->request->all(), [
            'name' => 'required|string',
            'description' => 'nullable|string',
            'mt_product_category_id' => 'required|exists:mt_product_category,id',
            'image_id' => 'nullable|exists:mt_files_storage,id',
            'file_id' => 'nullable|exists:mt_files_storage,id',
        ]);

        if ($validator->fails()) {
            return response()->error($validator->errors()->first());
        }

        $data = $this->request->only([
            'name',
            'description',
            'mt_product_category_id',
            'image_id',
            'file_id',
        ]);

        try {
            $create = MtProductSeries::create($data);
            return response()->success($create, "Product series successfully created");
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return response()->error("Failed to create Product series, $message");
        }
    }

    public function show($id)
    {
        try {
            $data = MtProductSeries::with([
                    'mt_product_category.mt_vendor.mt_manufacture_type',
                    'image',
                    'file',
                ])
                ->findOrFail($id);

            return response()->success($data, "Product series '$id' successfully fetched");
        } catch (\Exception $e) {
            return response()->error("Product series with id '$id' not found");
        }
    }

    public function update($id)
    {
        $params = [
            ...$this->request->all(),
            'id' => $id
        ];
        $validator = Validator::make($params, [
            'id' => 'required|exists:mt_product_series,id',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'mt_product_category_id' => 'required|exists:mt_product_category,id',
            'image_id' => 'nullable|exists:mt_files_storage,id',
            'file_id' => 'nullable|exists:mt_files_storage,id',
        ]);

        if ($validator->fails()) {
            return response()->error($validator->errors()->first());
        }

        $data = $this->request->only([
            'name',
            'description',
            'mt_product_category_id',
            'image_id',
            'file_id',
        ]);

        try {
            $update = MtProductSeries::findOrFail($id);
            $update->update($data);

            return response()->success($update, "Product series '$id' successfully updated");
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return response()->error("Failed to update product series '$id', $message");
        }
    }

    public function destroy($id)
    {
        try {
            $delete = MtProductSeries::findOrFail($id);
            $delete->delete();

            return response()->success(null, "Product series '$id' deleted successful");
        } catch (\Exception $e) {
            return response()->error("Product series with id '$id' not found");
        }
    }
}