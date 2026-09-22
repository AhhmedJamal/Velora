<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_id' => ['required', 'exists:customers,id'],
            'items' => ['required', 'array'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages()
    {
        return [
            'customer_id.required' => 'الرجاء اختيار العميل.',
            'customer_id.exists' => 'العميل غير موجود.',
            'items.required' => 'الرجاء إضافة منتج واحد على الأقل.',
            'items.array' => 'المنتجات يجب أن تكون مصفوفة.',
            'items.*.product_id.required' => 'الرجاء اختيار المنتج لكل عنصر.',
            'items.*.product_id.exists' => 'المنتج المحدد غير موجود لكل عنصر.',
            'items.*.quantity.required' => 'الرجاء إدخال الكمية لكل عنصر.',
            'items.*.quantity.integer' => 'الكمية يجب أن تكون رقمًا صحيحًا.',
            'items.*.quantity.min' => 'الكمية يجب أن تكون 1 على الأقل.',
        ];
    }
}
