<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FabricStock extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function fabric()
    {
        return $this->belongsTo(Fabric::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
