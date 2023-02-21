<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrganizationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'data' => $validator->errors(),
            'message' => 'Something is wrong with this field!',
        ]));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:250|min:3',
            'email' => 'required|email|max:30|min:3',
            'username' => 'nullable|max:30|min:3',
            'password'=> 'required|max:30|min:3',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'sub_domain'=> 'nullable|max:30',
            'db_name'=> 'nullable|max:30',
            'db_username'=> 'nullable|max:30',
            'db_password'=> 'nullable|max:30',
            'is_active'=> 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'A title is required',
            'body.required' => 'A message is required',
        ];
    }
}
