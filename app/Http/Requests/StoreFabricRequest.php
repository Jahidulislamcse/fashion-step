<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFabricRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'supplier_id' => 'required|exists:suppliers,id',
            'fabric_no' => 'required|string|max:100|unique:fabrics,fabric_no',
            'composition' => 'required|string|max:255',
            'gsm' => 'required|numeric|min:0',
            'qty' => 'required|numeric|min:0',
            'cuttable_width' => 'required|string|max:50',
            'production_type' => 'required|in:Sample Yardage,SMS,Bulk',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}
