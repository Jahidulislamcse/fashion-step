<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'country' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:suppliers,code',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'rep_email' => 'nullable|email',
            'rep_phone' => 'nullable|string',
        ];
    }
}
