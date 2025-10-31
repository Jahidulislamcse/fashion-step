<?php

use App\Http\Controllers\FabricController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;

Route::get('suppliers/trash', [SupplierController::class, 'trash']);
Route::post('suppliers/{id}/restore', [SupplierController::class, 'restore']);

Route::apiResource('suppliers', SupplierController::class);

Route::get('fabrics/trash', [FabricController::class, 'trash']);
Route::post('fabrics/{id}/restore', [FabricController::class, 'restore']);
Route::get('fabrics/{id}/print-barcode', [FabricController::class, 'printBarcode']);

Route::apiResource('fabrics', FabricController::class);
