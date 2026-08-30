<?php

namespace App\Http\Controllers;

use App\Models\MtManufactureType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class ManufactureTypeController extends Controller
{
    private $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }


    public function index()
    {
        $params = $this->request->all();
        $data = new MtManufactureType();
        $data = $data->with([
            'mt_vendor.image',
            'mt_vendor.mt_product_category.mt_product_series',
            'mt_vendor.mt_product_category.image',
            'image',
        ]);

        if (!empty($params['page']) && !empty($params['items_per_page'])) {
            $data = $data->paginate($params['items_per_page'], '*', 'page', $params['page']);
        } else {
            $data = $data->get();
        }

        return response()->success($data, "Manufacture types successfully fetched");
    }

    public function store()
    {
        $validator = Validator::make($this->request->all(), [
            'name' => 'required|string',
            'description' => 'nullable|string',
            'image_id' => 'nullable|exists:mt_files_storage,id',
        ]);

        if ($validator->fails()) {
            return response()->error($validator->errors()->first());
        }

        $params = $this->request->only([
            'name',
            'description',
            'image_id',
        ]);

        try {
            $create = MtManufactureType::create($params);
            return response()->success($create, "Manufacture type successfully created");
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return response()->error("Failed when creating manufacture type, $message");
        }
    }

    public function show($id)
    {
        try {
            $data = MtManufactureType::with([
                    'mt_vendor.image',
                    'mt_vendor.mt_product_category.mt_product_series',
                    'image',
                ])
                ->findOrFail($id);

            return response()->success($data, "Manufacture type '$id' successfully fetched");
        } catch (\Exception $e) {
            return response()->error("Manufacture type with id '$id' not found");
        }
    }

    public function showByName($name)
    {
        try {
            $data = MtManufactureType::with([
                    'mt_vendor.image',
                    'mt_vendor.mt_product_category.mt_product_series',
                    'image',
                ])
                ->whereRaw("UPPER(name) LIKE UPPER(?)", [$name])
                // ->dd();
                ->first();

            return response()->success($data, "Manufacture type '$name' successfully fetched");
        } catch (\Exception $e) {
            return response()->error("Manufacture type with name '$name' not found");
        }
    }

    public function update($id)
    {
        $params = [
            ...$this->request->all(),
            'id' => $id
        ];
        $validator = Validator::make($params, [
            'id' => 'required|exists:mt_manufacture_type,id',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'image_id' => 'nullable|exists:mt_files_storage,id',
        ]);

        if ($validator->fails()) {
            return response()->error($validator->errors()->first());
        }

        $data = $this->request->only([
            'name',
            'description',
            'image_id',
        ]);

        try {
            $update = MtManufactureType::findOrFail($id);
            $update->update($data);

            return response()->success($update, "Manufacture type '$id' successfully updated");
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return response()->error("Failed when updating manufacture type '$id', $message");
        }
    }

    public function destroy($id)
    {
        try {
            $delete = MtManufactureType::findOrFail($id);
            $delete->delete();

            return response()->success(null, "Manufacture type '$id' deleted successful");
        } catch (\Exception $e) {
            return response()->error("Manufacture type with id '$id' not found");
        }
    }
}
