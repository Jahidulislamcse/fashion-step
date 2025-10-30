<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fabric extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function stocks()
    {
        return $this->hasMany(FabricStock::class);
    }

    public function barcodes()
    {
        return $this->hasMany(FabricBarcode::class);
    }

    public function notes()
    {
        return $this->morphMany(Note::class, 'noteable');
    }

    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function setFabricNoAttribute($value)
    {
        $this->attributes['fabric_no'] = strtoupper(trim($value));
    }

    public function getAvailableBalanceAttribute()
    {
        $in = $this->stocks()->where('transaction_type', 'in')->sum('quantity');
        $out = $this->stocks()->where('transaction_type', 'out')->sum('quantity');
        return $in - $out;
    }

    public function scopeFilter($query, $filters)
    {
        if (!empty($filters['fabric_no']))
            $query->where('fabric_no', 'like', "%{$filters['fabric_no']}%");

        if (!empty($filters['composition']))
            $query->where('composition', 'like', "%{$filters['composition']}%");

        if (!empty($filters['production_type']))
            $query->where('production_type', $filters['production_type']);

        if (!empty($filters['company_name'])) {
            $query->whereHas('supplier', function ($q) use ($filters) {
                $q->where('company_name', 'like', "%{$filters['company_name']}%");
            });
        }

        return $query;
    }
}
