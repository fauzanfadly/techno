<?php

namespace App\Http\Controllers;

use App\Models\MtVendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class VendorController extends Controller
{
    private $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }


    public function index()
    {
        $params = $this->request->all();
        $data = new MtVendor();
        $data = $data->with([
                'mt_manufacture_type.mt_vendor',
                'mt_product_category.mt_product_series.image',
                'mt_product_category.mt_product_series.file',
                'mt_product_category.image',
                'image',
            ]);

        $data = empty($params['manufacture_type_name']) ? $data
            : $data->select('mt_vendor.*')
                ->leftJoin('mt_manufacture_type AS mmt', 'mmt.id', 'mt_vendor.mt_manufacture_type_id')
                ->whereRaw("UPPER(mmt.name) LIKE UPPER(?)", [$params['manufacture_type_name']]);

        if (!empty($params['page']) && !empty($params['items_per_page'])) {
            $data = $data->paginate($params['items_per_page'], 'mt_vendor.*', 'page', $params['page']);
        } else {
            $data = $data->get();
        }

        return response()->success($data, "Vendor successfully fetched");
    }

    public function store()
    {
        $validator = Validator::make($this->request->all(), [
            'name' => 'required|string',
            'description' => 'nullable|string',
            'mt_manufacture_type_id' => 'required|exists:mt_manufacture_type,id',
            'image_id' => 'nullable|exists:mt_files_storage,id',
        ]);

        if ($validator->fails()) {
            return response()->error($validator->errors()->first());
        }

        $data = $this->request->only([
            'name',
            'description',
            'mt_manufacture_type_id',
            'image_id',
        ]);

        try {
            $create = MtVendor::create($data);
            return response()->success($create, "Vendor successfully created");
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return response()->error("Failed when creating vendor, $message");
        }
    }

    public function show($id)
    {
        try {
            $data = MtVendor::with([
                    'mt_manufacture_type.mt_vendor',
                    'mt_product_category.mt_product_series.image',
                    'mt_product_category.mt_product_series.file',
                    'mt_product_category.image',
                    'image',
                ])
                ->findOrFail($id);

            return response()->success($data, "Vendor '$id' successfully fetched");
        } catch (\Exception $e) {
            return response()->error("Vendor with id '$id' not found");
        }
    }

    public function update($id)
    {
        $params = [
            ...$this->request->all(),
            'id' => $id
        ];
        $validator = Validator::make($params, [
            'id' => 'required|exists:mt_vendor,id',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'mt_manufacture_type_id' => 'required|exists:mt_manufacture_type,id',
            'image_id' => 'nullable|exists:mt_files_storage,id',
        ]);

        if ($validator->fails()) {
            return response()->error($validator->errors()->first());
        }

        $data = $this->request->only([
            'name',
            'description',
            'mt_manufacture_type_id',
            'image_id',
        ]);

        try {
            $update = MtVendor::findOrFail($id);
            $update->update($data);

            return response()->success($update, "Vendor '$id' successfully updated");
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return response()->error("Failed when updating vendor '$id', $message");
        }
    }

    public function destroy($id)
    {
        try {
            $delete = MtVendor::findOrFail($id);
            $delete->delete();

            return response()->success(null, "Vendor '$id' successfully deleted");
        } catch (\Exception $e) {
            return response()->error("Vendor with id '$id' not found");
        }
    }
}