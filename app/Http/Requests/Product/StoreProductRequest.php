<?php

namespace App\Http\Requests\Product;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'product_name' => 'required|string',
            'small_description' => 'required|string',
            'description' => 'required|string',
            'category_id' => 'required|integer',
            'unit_id' => 'required|integer',
            'difficulty' => 'required|integer',
            'isActive' => 'required|integer',
            'stock' => 'required|integer',
            'buying_price' => 'required|integer',
            'selling_price' => 'required|integer',
             'materials' => 'required|array', // Assure que c'est un tableau
            'materials.*' => 'string', // Vérifie que chaque élément du tableau est une chaîne de caractères
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'product_code' => IdGenerator::generate([
                'table' => 'products',
                'field' => 'product_code',
                'length' => 4,
                'prefix' => 'PC'
            ])
        ]);

    }
}
