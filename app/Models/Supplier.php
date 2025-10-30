<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function fabrics()
    {
        return $this->hasMany(Fabric::class);
    }

    public function notes()
    {
        return $this->morphMany(Note::class, 'noteable');
    }

    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function setCompanyNameAttribute($value)
    {
        $this->attributes['company_name'] = ucwords(strtolower($value));
    }

    public function scopeFilter($query, $filters)
    {
        if (!empty($filters['country']))
            $query->where('country', 'like', "%{$filters['country']}%");

        if (!empty($filters['company_name']))
            $query->where('company_name', 'like', "%{$filters['company_name']}%");

        if (!empty($filters['rep_name']))
            $query->where('rep_name', 'like', "%{$filters['rep_name']}%");

        if (!empty($filters['from']) && !empty($filters['to']))
            $query->whereBetween('created_at', [$filters['from'], $filters['to']]);

        return $query;
    }
}
