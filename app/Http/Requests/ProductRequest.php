<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
        public function rules(): array
        {
            return [
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'description' => 'nullable|string',
            ];
        }
        public function messages(): array
        {
            return [
                'category_id.required' => 'The category field is required.',
                'category_id.exists' => 'The selected category is invalid.',
                'name.required' => 'The name field is required.',
                'name.string' => 'The name field must be a string.',
                'name.max' => 'The name field must be less than 255 characters.',
                'image.required' => 'The image field is required.',
                'image.image' => 'The image field must be an image.',
                'image.mimes' => 'The image field must be a file of type: jpeg, png, jpg, gif, svg.',
                'image.max' => 'The image field must be less than 5120 kilobytes.',
                'price.required' => 'The price field is required.',
                'price.numeric' => 'The price field must be a number.',
                'price.min' => 'The price field must be greater than 0.',
                'stock.required' => 'The stock field is required.',
                'stock.integer' => 'The stock field must be an integer.',
                'stock.min' => 'The stock field must be greater than 0.',
                'description.string' => 'The description field must be a string.',
                'description.max' => 'The description field must be less than 255 characters.',
            ];
        }
        public function attributes(): array
        {
            return [
                'category_id' => 'Category',
                'name' => 'Name',
                'image' => 'Image',
                'price' => 'Price',
                'stock' => 'Stock',
                'description' => 'Description',
            ];
        }
    }
