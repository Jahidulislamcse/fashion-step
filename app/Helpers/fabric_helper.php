<?php

use App\Models\FabricStock;

if (! function_exists('calculateFabricBalance')) {
    function calculateFabricBalance($fabricId)
    {
        $in = FabricStock::where('fabric_id', $fabricId)
            ->where('transaction_type', 'in')->sum('quantity');
        $out = FabricStock::where('fabric_id', $fabricId)
            ->where('transaction_type', 'out')->sum('quantity');
        return $in - $out;
    }
}
