<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $suppliers = Supplier::filter($request->all())
            ->withCount('fabrics')
            ->paginate(10);
        return response()->json($suppliers);
    }

    public function store(StoreSupplierRequest $request)
    {
        $data = $request->validated();
        $data['added_by'] = auth()->id() ?? 1;
        $supplier = Supplier::create($data);
        return response()->json(['message' => 'Supplier created', 'data' => $supplier], 201);
    }

    public function show(Supplier $supplier)
    {
        return response()->json($supplier->load('fabrics'));
    }

    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        $data = $request->validated();
        $data['updated_by'] = auth()->id() ?? 1;
        $supplier->update($data);
        return response()->json(['message' => 'Supplier updated', 'data' => $supplier]);
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return response()->json(['message' => 'Supplier soft-deleted']);
    }

    public function trash()
    {
        $trashed = Supplier::onlyTrashed()->paginate(10);
        return response()->json($trashed);
    }

    public function restore($id)
    {
        $supplier = Supplier::withTrashed()->findOrFail($id);
        $supplier->restore();
        return response()->json(['message' => 'Supplier restored']);
    }
}
