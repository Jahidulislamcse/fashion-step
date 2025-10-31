<?php

namespace App\Http\Controllers;

use App\Models\Fabric;
use App\Models\FabricBarcode;
use App\Http\Requests\StoreFabricRequest;
use App\Http\Requests\UpdateFabricRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Milon\Barcode\Facades\DNS1D;

class FabricController extends Controller
{
    public function index(Request $request)
    {
        $fabrics = Fabric::with('supplier')
            ->filter($request->all())
            ->paginate(10);

        $fabrics->getCollection()->transform(function ($item) {
            $item->available_balance = $item->available_balance;
            return $item;
        });

        return response()->json($fabrics);
    }

    public function store(StoreFabricRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('fabrics', 'public');
            $data['image_path'] = $path;
        }

        unset($data['image']);

        $data['added_by'] = auth()->id() ?? 1;
        $fabric = Fabric::create($data);

        $barcodeValue = 'FAB-' . strtoupper(Str::random(10));
        FabricBarcode::create([
            'fabric_id' => $fabric->id,
            'barcode_value' => $barcodeValue,
            'generated_by' => auth()->id() ?? 1,
        ]);

        return response()->json([
            'message' => 'Fabric created successfully',
            'data' => $fabric,
            'barcode' => $barcodeValue
        ], 201);
    }

    public function show(Fabric $fabric)
    {
        return response()->json($fabric->load(['supplier', 'barcodes', 'stocks']));
    }

    public function update(UpdateFabricRequest $request, Fabric $fabric)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            if ($fabric->image_path && Storage::disk('public')->exists($fabric->image_path)) {
                Storage::disk('public')->delete($fabric->image_path);
            }
            $path = $request->file('image')->store('fabrics', 'public');
            $data['image_path'] = $path;
        }

        $data['updated_by'] = auth()->id() ?? 1;
        $fabric->update($data);
        return response()->json(['message' => 'Fabric updated', 'data' => $fabric]);
    }

    public function destroy(Fabric $fabric)
    {
        $fabric->delete();
        return response()->json(['message' => 'Fabric soft-deleted']);
    }

    
}
