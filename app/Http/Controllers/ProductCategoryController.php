<?php

namespace App\Http\Controllers;

use App\Models\MtProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ProductCategoryController extends Controller
{
    private $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }


    public function index()
    {
        $params = $this->request->all();
        $data = new MtProductCategory();
        $data = $data->with([
                'mt_vendor.mt_manufacture_type',
                'image'
            ]);

        if (!empty($params['page']) && !empty($params['items_per_page'])) {
            $data = $data->paginate($params['items_per_page'], '*', 'page', $params['page']);
        } else {
            $data = $data->get();
        }

        return response()->success($data, "Product categories successfully fetched");
    }

    public function store()
    {
        $validator = Validator::make($this->request->all(), [
            'name' => 'required|string',
            'description' => 'nullable|string',
            'mt_vendor_id' => 'required|exists:mt_vendor,id',
            'image_id' => 'nullable|exists:mt_images_storage,id',
        ]);

        if ($validator->fails()) {
            return response()->error($validator->errors()->first());
        }

        $data = $this->request->only([
            'name',
            'description',
            'mt_vendor_id',
            'image_id',
        ]);

        try {
            $create = MtProductCategory::create($data);
            return response()->success($create, "Product category successfully created");
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return response()->error("Failed when create product category, $message");
        }
    }

    public function show($id)
    {
        try {
            $data = MtProductCategory::with([
                    'mt_vendor.mt_manufacture_type',
                    'image'
                ])
                ->findOrFail($id);

            return response()->success($data, "Product category '$id' successfully fetched");
        } catch (\Exception $e) {
            return response()->error("Product category with id '$id' not found");
        }
    }

    public function update($id)
    {
        $params = [
            ...$this->request->all(),
            'id' => $id
        ];
        $validator = Validator::make($params, [
            'id' => 'required|exists:mt_product_category,id',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'mt_vendor_id' => 'required|exists:mt_vendor,id',
            'image_id' => 'nullable|exists:mt_images_storage,id',
        ]);

        if ($validator->fails()) {
            return response()->error($validator->errors()->first());
        }

        $data = $this->request->only([
            'name',
            'description',
            'mt_vendor_id',
            'image_id',
        ]);

        try {
            $update = MtProductCategory::findOrFail($id);
            $update->update($data);

            return response()->success($update, "Product category '$id' successfully updated");
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return response()->error("Failed when update product category '$id', $message");
        }
    }

    public function destroy($id)
    {
        try {
            $delete = MtProductCategory::findOrFail($id);
            $delete->delete();

            return response()->success(null, "Product category '$id' successfully deleted");
        } catch (\Exception $e) {
            return response()->error("Product category with id '$id' not found");
        }
    }
}