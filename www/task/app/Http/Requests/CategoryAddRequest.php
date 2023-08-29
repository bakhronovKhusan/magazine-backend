<?php

namespace App\Http\Requests;

use App\DTO\CreateCategoryDTO;
use App\DTO\CreateProductDTO;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CategoryAddRequest extends FormRequest
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
            'name' => 'required|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'has_child' => 'required|in:0,1',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        $errors = [];
        foreach($validator->errors()->messages() as $error) {
            $errors[] = $error[0];
        }

        $json = [
            'status'  => 'error',
            'errors'  => $errors
        ];
        throw new HttpResponseException(response()->json($json));
    }
}
