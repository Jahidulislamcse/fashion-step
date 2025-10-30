<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;

Route::apiResource('suppliers', SupplierController::class);
Route::get('suppliers/trash', [SupplierController::class, 'trash']);
Route::post('suppliers/{id}/restore', [SupplierController::class, 'restore']);

