<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UsersWithinRadius extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'radius' => 'required|numeric',
            'lat' => 'required|numeric|between:-90,90',
            'lng' => 'required|numeric|between:-180,180',
        ];
    }

    public function messages()
    {
        return [
            'radius.required' => 'Radius is required',
            'radius.numeric' => 'Radius must be a number',
            'lat.required' => 'The latitude is required.',
            'lat.numeric' => 'The latitude must be a number.',
            'lat.between' => 'The latitude must be between -90 and 90 degrees.',
            'lng.required' => 'The longitude is required.',
            'lng.numeric' => 'The longitude must be a number.',
            'lng.between' => 'The longitude must be between -180 and 180 degrees.',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422)
        );
    }

}
