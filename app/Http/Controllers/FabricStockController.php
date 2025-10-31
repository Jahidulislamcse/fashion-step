<?php

namespace App\Http\Controllers;

use App\Models\FabricStock;
use Illuminate\Http\Request;

class FabricStockController extends Controller
{
    public function index(Request $request)
    {
        $stocks = FabricStock::with('fabric')->latest()->paginate(10);
        return response()->json($stocks);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'fabric_id' => 'required|exists:fabrics,id',
            'transaction_type' => 'required|in:in,out',
            'quantity' => 'required|numeric|min:1',
            'reference' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        $data['created_by'] = auth()->id() ?? 1;
        $stock = FabricStock::create($data);

        return response()->json(['message' => 'Stock recorded', 'data' => $stock]);
    }
}
