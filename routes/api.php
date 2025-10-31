<?php

use App\Http\Controllers\FabricController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;

Route::get('suppliers/trash', [SupplierController::class, 'trash']);
Route::post('suppliers/{id}/restore', [SupplierController::class, 'restore']);

Route::apiResource('suppliers', SupplierController::class);

Route::apiResource('fabrics', FabricController::class);
