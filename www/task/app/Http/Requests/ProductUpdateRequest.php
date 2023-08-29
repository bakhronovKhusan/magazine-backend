<?php

namespace App\Http\Requests;

use App\DTO\CreateProductDTO;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductUpdateRequest extends FormRequest
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
            'name'        => 'min:1|max:191',
            'description' => 'min:1',
            'is_exist'    => 'min:1',
            'price'       => 'min:1',
            'category.*' => 'min:1|exists:categories,id',
            'file.*'      => 'image|mimes:jpeg,png,jpg,gif|max:2048',
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
