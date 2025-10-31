<?php

use App\Http\Controllers\FabricController;
use App\Http\Controllers\FabricStockController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::apiResource('suppliers', SupplierController::class);
Route::get('suppliers/trash', [SupplierController::class, 'trash']);
Route::post('suppliers/{id}/restore', [SupplierController::class, 'restore']);

Route::apiResource('fabrics', FabricController::class);
Route::get('fabrics/trash', [FabricController::class, 'trash']);
Route::post('fabrics/{id}/restore', [FabricController::class, 'restore']);
Route::get('fabrics/{id}/print-barcode', [FabricController::class, 'printBarcode']);

Route::apiResource('fabric-stocks', FabricStockController::class)->only(['index', 'store']);