<?php

namespace App\Http\Controllers;

use App\Models\Fabric;
use App\Models\FabricBarcode;
use App\Http\Requests\StoreFabricRequest;
use App\Http\Requests\UpdateFabricRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Milon\Barcode\DNS1D;

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
        if ($request->isMethod('put') && empty($request->all())) {
            $request->merge($request->post());
        }

        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($fabric->image_path && Storage::disk('public')->exists($fabric->image_path)) {
                Storage::disk('public')->delete($fabric->image_path);
            }

            $path = $request->file('image')->store('fabrics', 'public');
            $data['image_path'] = $path;
        }

        unset($data['image']);

        $data['updated_by'] = auth()->id() ?? 1;

        $fabric->update($data);

        return response()->json([
            'message' => 'Fabric updated successfully',
            'data' => $fabric->fresh(), 
        ]);
    }

    public function destroy(Fabric $fabric)
    {
        $fabric->delete();
        return response()->json(['message' => 'Fabric soft-deleted']);
    }

    public function trash()
    {
        $trashed = Fabric::onlyTrashed()->paginate(10);
        return response()->json($trashed);
    }

    public function restore($id)
    {
        $fabric = Fabric::withTrashed()->findOrFail($id);
        $fabric->restore();
        return response()->json(['message' => 'Fabric restored']);
    }

    public function printBarcode($id)
    {
        $fabric = Fabric::findOrFail($id);
        $barcode = $fabric->barcodes()->latest()->first();

        if (!$barcode) {
            return response()->json(['message' => 'No barcode found for this fabric'], 404);
        }

        $dns1d = new DNS1D();

        $svg = $dns1d->getBarcodeSVG($barcode->barcode_value, 'C128');

        $html = "<h3>{$fabric->fabric_no}</h3>{$svg}<p>{$barcode->barcode_value}</p>";

        return response($html);
    }

}
