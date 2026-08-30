<?php

namespace App\Http\Controllers;

use App\Models\MtFolder;
use App\Services\FolderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FoldersController extends Controller
{
    private $request;
    private $folderService;

    public function __construct(
        Request $request,
        FolderService $folderService,
    ) {
        $this->request = $request;
        $this->folderService = $folderService;
    }

    public function index()
    {
        $data = MtFolder::query()->withCount(['children', 'files']);

        // ?parent_id= (kosong = root). Tanpa param sama sekali = semua folder (untuk tree).
        if ($this->request->has('parent_id')) {
            $parentId = $this->request->input('parent_id');
            if ($parentId === null || $parentId === '') {
                $data->whereNull('parent_id');
            } else {
                $data->where('parent_id', $parentId);
            }
        }

        return response()->success($data->orderBy('name')->get(), "Folders successfully fetched");
    }

    public function store()
    {
        $validator = Validator::make($this->request->all(), [
            'name' => 'required|string',
            'parent_id' => 'nullable|exists:mt_folders,id',
        ]);

        if ($validator->fails()) {
            return response()->error($validator->errors()->first());
        }

        $name = $this->request->input('name');
        $parentId = $this->request->input('parent_id');

        if ($this->duplicateExists($parentId, $name)) {
            return response()->error("Folder dengan nama '$name' sudah ada di lokasi ini");
        }

        try {
            $folder = $this->folderService->create($parentId, $name);
            return response()->success($folder, "Folder successfully created");
        } catch (\Exception $e) {
            return response()->error("Failed when creating folder, {$e->getMessage()}");
        }
    }

    public function update($id)
    {
        $validator = Validator::make(
            [...$this->request->all(), 'id' => $id],
            [
                'id' => 'required|exists:mt_folders,id',
                'name' => 'nullable|string',
                'parent_id' => 'nullable|exists:mt_folders,id',
            ]
        );

        if ($validator->fails()) {
            return response()->error($validator->errors()->first());
        }

        try {
            $folder = MtFolder::findOrFail($id);
        } catch (\Exception $e) {
            return response()->error("Folder with id '$id' not found");
        }

        // Susun atribut yang benar-benar dikirim
        $attrs = [];
        if ($this->request->has('name')) {
            $attrs['name'] = $this->request->input('name');
        }
        if ($this->request->has('parent_id')) {
            $attrs['parent_id'] = $this->request->input('parent_id');
        }

        // Cek nama kembar di lokasi tujuan (kecuali diri sendiri)
        $targetName = $attrs['name'] ?? $folder->name;
        $targetParent = array_key_exists('parent_id', $attrs) ? $attrs['parent_id'] : $folder->parent_id;
        if ($this->duplicateExists($targetParent, $targetName, $folder->id)) {
            return response()->error("Folder dengan nama '$targetName' sudah ada di lokasi tujuan");
        }

        try {
            $updated = $this->folderService->update($folder, $attrs);
            return response()->success($updated, "Folder '$id' successfully updated");
        } catch (\Exception $e) {
            return response()->error("Failed when updating folder '$id', {$e->getMessage()}");
        }
    }

    public function destroy($id)
    {
        try {
            $folder = MtFolder::findOrFail($id);
        } catch (\Exception $e) {
            return response()->error("Folder with id '$id' not found");
        }

        try {
            $this->folderService->delete($folder);
            return response()->success(null, "Folder '$id' deleted successful");
        } catch (\Exception $e) {
            return response()->error("Failed when deleting folder '$id', {$e->getMessage()}");
        }
    }

    private function duplicateExists($parentId, string $name, $exceptId = null): bool
    {
        $query = MtFolder::where('name', $name);
        $parentId ? $query->where('parent_id', $parentId) : $query->whereNull('parent_id');
        if ($exceptId) {
            $query->where('id', '!=', $exceptId);
        }
        return $query->exists();
    }
}
