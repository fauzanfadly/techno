<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FilesStorageController;
use App\Http\Controllers\FoldersController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductSeriesController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ManufactureTypeController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);
Route::post('refresh', [AuthController::class, 'refresh']);

Route::get('manufacture-type', [ManufactureTypeController::class, 'index']);
Route::get('manufacture-type/detail/{id}', [ManufactureTypeController::class, 'show']);
Route::get('manufacture-type/detail/name/{name}', [ManufactureTypeController::class, 'showByName']);
Route::get('vendor', [VendorController::class, 'index']);
Route::get('vendor/detail/{id}', [VendorController::class, 'show']);
Route::prefix('product')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('detail/{id}', [ProductController::class, 'show']);
    Route::get('series', [ProductSeriesController::class, 'index']);
    Route::get('series/detail/{id}', [ProductSeriesController::class, 'show']);
    Route::get('category', [ProductCategoryController::class, 'index']);
    Route::get('category/detail/{id}', [ProductCategoryController::class, 'show']);
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('my-user', [AuthController::class, 'myUser']);

    Route::prefix('assets-manager')->group(function () {
        // Sistem berfolder (mt_folders + mt_files_storage)
        Route::prefix('folder')->group(function () {
            Route::get('/', [FoldersController::class, 'index']);
            Route::post('/create', [FoldersController::class, 'store']);
            Route::post('/update/{id}', [FoldersController::class, 'update']);
            Route::delete('/delete/{id}', [FoldersController::class, 'destroy']);
        });

        Route::prefix('file')->group(function () {
            Route::get('/', [FilesStorageController::class, 'index']);
            Route::get('/detail/{id}', [FilesStorageController::class, 'show']);
            Route::post('/create', [FilesStorageController::class, 'store']);
            Route::post('/update/{id}', [FilesStorageController::class, 'update']);
            Route::delete('/remove/{id}', [FilesStorageController::class, 'remove']);
            Route::delete('/delete/{id}', [FilesStorageController::class, 'destroy']);
        });
    });

    Route::prefix('manufacture-type')->group(function () {
        Route::post('/create', [ManufactureTypeController::class, 'store']);
        Route::post('/update/{id}', [ManufactureTypeController::class, 'update']);
        Route::delete('/delete/{id}', [ManufactureTypeController::class, 'destroy']);
    });

    Route::prefix('vendor')->group(function () {
        Route::post('/create', [VendorController::class, 'store']);
        Route::post('/update/{id}', [VendorController::class, 'update']);
        Route::delete('/delete/{id}', [VendorController::class, 'destroy']);
    });

    Route::prefix('product')->group(function () {
        Route::post('/create', [ProductController::class, 'store']);
        Route::post('/update/{id}', [ProductController::class, 'update']);
        Route::delete('/delete/{id}', [ProductController::class, 'destroy']);

        Route::prefix('series')->group(function () {
            Route::post('/create', [ProductSeriesController::class, 'store']);
            Route::post('/update/{id}', [ProductSeriesController::class, 'update']);
            Route::delete('/delete/{id}', [ProductSeriesController::class, 'destroy']);
        });

        Route::prefix('category')->group(function () {
            Route::post('/create', [ProductCategoryController::class, 'store']);
            Route::post('/update/{id}', [ProductCategoryController::class, 'update']);
            Route::delete('/delete/{id}', [ProductCategoryController::class, 'destroy']);
        });
    });
});
