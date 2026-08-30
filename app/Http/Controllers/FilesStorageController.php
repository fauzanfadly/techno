<?php

namespace App\Http\Controllers;

use App\Models\MtFilesStorage;
use App\Models\MtFolder;
use App\Services\FolderService;
use App\Services\UploadFileServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FilesStorageController extends Controller
{
    private const IMAGE_EXT = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg'];
    private const DOC_EXT = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'csv'];
    private const IMAGE_MAX_BYTES = 10 * 1024 * 1024; // 10MB

    /** Kolom FK entity yang boleh di-detach lewat endpoint remove. */
    private const REMOVE_MODULES = [
        'PRODUCT' => \App\Models\MtProduct::class,
        'PRODUCT SERIES' => \App\Models\MtProductSeries::class,
        'PRODUCT CATEGORY' => \App\Models\MtProductCategory::class,
        'VENDOR' => \App\Models\MtVendor::class,
        'MANUFACTURE TYPE' => \App\Models\MtManufactureType::class,
    ];

    private $request;
    private $uploadFileServices;
    private $folderService;

    public function __construct(
        Request $request,
        UploadFileServices $uploadFileServices,
        FolderService $folderService,
    ) {
        $this->request = $request;
        $this->uploadFileServices = $uploadFileServices;
        $this->folderService = $folderService;
    }

    public function index()
    {
        $params = $this->request->all();
        $data = MtFilesStorage::with(['mt_product', 'folder']);

        if ($this->request->has('folder_id')) {
            $folderId = $this->request->input('folder_id');
            if ($folderId === null || $folderId === '') {
                $data->whereNull('folder_id');
            } else {
                $data->where('folder_id', $folderId);
            }
        }

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
            'folder_id' => 'nullable|exists:mt_folders,id',
            'file' => 'required|file|max:51200', // 50MB ceiling
        ]);

        if ($validator->fails()) {
            return response()->error($validator->errors()->first());
        }

        $file = $this->request->file('file');
        if ($error = $this->validateFile($file)) {
            return response()->error($error);
        }

        $data = $this->request->only(['name', 'description']);
        $folderId = $this->request->input('folder_id');

        try {
            $folder = $folderId ? MtFolder::find($folderId) : null;
            $upload = $this->uploadFileServices->saveUploadFile($file, $folder?->path);
            $data = array_merge($data, $upload, ['folder_id' => $folderId]);
        } catch (\Exception $e) {
            return response()->error("Failed when saving uploaded file to storage, {$e->getMessage()}");
        }

        try {
            $create = MtFilesStorage::create($data);
            return response()->success($create, "File successfully created");
        } catch (\Exception $e) {
            return response()->error("Failed when creating file, {$e->getMessage()}");
        }
    }

    public function show($id)
    {
        try {
            $data = MtFilesStorage::with(['mt_product', 'folder'])->findOrFail($id);
            return response()->success($data, "File '$id' successfully fetched");
        } catch (\Exception $e) {
            return response()->error("File with id '$id' not found");
        }
    }

    public function update($id)
    {
        $validator = Validator::make(
            [...$this->request->all(), 'id' => $id],
            [
                'id' => 'required|exists:mt_files_storage,id',
                'name' => 'nullable|string',
                'description' => 'nullable|string',
                'folder_id' => 'nullable|exists:mt_folders,id',
                'file' => 'nullable|file|max:51200',
            ]
        );

        if ($validator->fails()) {
            return response()->error($validator->errors()->first());
        }

        try {
            $file = MtFilesStorage::findOrFail($id);
        } catch (\Exception $e) {
            return response()->error("File with id '$id' not found");
        }

        $data = $this->request->only(['name', 'description']);

        // Folder tujuan (kalau tidak dikirim, tetap folder saat ini)
        $targetFolderId = $this->request->has('folder_id')
            ? $this->request->input('folder_id')
            : $file->folder_id;
        $targetFolder = $targetFolderId ? MtFolder::find($targetFolderId) : null;
        $targetPath = $targetFolder?->path;

        try {
            if ($this->request->hasFile('file')) {
                $newFile = $this->request->file('file');
                if ($error = $this->validateFile($newFile)) {
                    return response()->error($error);
                }

                // Ganti file: hapus fisik lama, simpan baru di folder tujuan
                if ($file->file_path) {
                    Storage::disk('public')->delete($file->file_path);
                }
                $upload = $this->uploadFileServices->saveUploadFile($newFile, $targetPath);
                $data = array_merge($data, $upload, ['folder_id' => $targetFolderId]);
            } elseif ($this->request->has('folder_id') && $targetFolderId != $file->folder_id) {
                // Pindah file antar folder (tanpa ganti isi)
                $newRelative = $this->folderService->diskDir($targetPath) . '/' . $file->file_name;
                File::ensureDirectoryExists(Storage::disk('public')->path($this->folderService->diskDir($targetPath)));
                Storage::disk('public')->move($file->file_path, $newRelative);
                $data['file_path'] = $newRelative;
                $data['folder_id'] = $targetFolderId;
            }
        } catch (\Exception $e) {
            return response()->error("Failed when saving uploaded file to storage, {$e->getMessage()}");
        }

        try {
            $file->update($data);
            return response()->success($file->fresh(), "File '$id' successfully updated");
        } catch (\Exception $e) {
            return response()->error("Failed when updating file '$id', {$e->getMessage()}");
        }
    }

    public function remove($id)
    {
        $params = $this->request->all();
        $type = $params['module_type'] ?? '';
        $typeUpper = strtoupper($type);
        $column = $params['column'] ?? 'file_id';

        if (!in_array($column, ['image_id', 'file_id'], true)) {
            return response()->error("Column '$column' is not accepted");
        }
        if (empty(self::REMOVE_MODULES[$typeUpper])) {
            return response()->error("Module type '$type' is not accepted");
        }
        if (empty($params['module_id'])) {
            return response()->error("module_id is required");
        }

        try {
            MtFilesStorage::findOrFail($id);
        } catch (\Exception $e) {
            return response()->error("File with id '$id' not found");
        }

        try {
            $model = self::REMOVE_MODULES[$typeUpper];
            $model::where('id', $params['module_id'])->update([$column => null]);
            return response()->success(null, "File '$id' detached successful");
        } catch (\Exception $e) {
            $moduleId = $params['module_id'];
            return response()->error("Failed when detaching file from '$type' at id '$moduleId', {$e->getMessage()}");
        }
    }

    public function destroy($id)
    {
        try {
            $file = MtFilesStorage::findOrFail($id);
        } catch (\Exception $e) {
            return response()->error("File with id '$id' not found");
        }

        try {
            $this->folderService->detach([$file->id]);
            if ($file->file_path) {
                Storage::disk('public')->delete($file->file_path);
            }
            $file->delete();
            return response()->success(null, "File '$id' deleted successful");
        } catch (\Exception $e) {
            return response()->error("Failed when deleting file '$id', {$e->getMessage()}");
        }
    }

    /** Validasi ekstensi whitelist + batas ukuran per tipe. Return pesan error atau null. */
    private function validateFile($file): ?string
    {
        $ext = strtolower($file->getClientOriginalExtension());
        $allowed = array_merge(self::IMAGE_EXT, self::DOC_EXT);

        if (!in_array($ext, $allowed, true)) {
            return "Tipe file .$ext tidak diizinkan";
        }
        if (in_array($ext, self::IMAGE_EXT, true) && $file->getSize() > self::IMAGE_MAX_BYTES) {
            return "Ukuran gambar maksimal 10MB";
        }
        return null;
    }
}
