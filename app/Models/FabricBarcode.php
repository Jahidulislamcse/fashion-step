<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FabricBarcode extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function fabric()
    {
        return $this->belongsTo(Fabric::class);
    }

    public function generatedBy()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }
}
