<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFabricRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $fabric = $this->route('fabric');
        $id = $fabric instanceof \App\Models\Fabric ? $fabric->id : $fabric;

        return [
            'supplier_id' => 'required|exists:suppliers,id',
            'fabric_no' => "required|string|max:100|unique:fabrics,fabric_no,{$id}",
            'composition' => 'required|string|max:255',
            'gsm' => 'required|numeric|min:0',
            'qty' => 'required|numeric|min:0',
            'cuttable_width' => 'required|string|max:50',
            'production_type' => 'required|in:Sample Yardage,SMS,Bulk',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'construction' => 'nullable|string|max:255',
            'color_pantone_code' => 'nullable|string|max:100',
            'weave_type' => 'nullable|string|max:100',
            'finish_type' => 'nullable|string|max:100',
            'dyeing_method' => 'nullable|string|max:100',
            'printing_method' => 'nullable|string|max:100',
            'lead_time' => 'nullable|string|max:50',
            'moq' => 'nullable|numeric|min:0',
            'shrinkage' => 'nullable|numeric|min:0|max:100',
            'remarks' => 'nullable|string|max:500',
            'fabric_selected_by' => 'nullable|string|max:255',
        ];
    }
}
