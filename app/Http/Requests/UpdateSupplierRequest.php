<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('supplier')->id ?? $this->route('supplier');
        return [
            'country' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'code' => "required|string|max:50|unique:suppliers,code,$id",
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'rep_email' => 'nullable|email',
            'rep_phone' => 'nullable|string',
        ];
    }
}
