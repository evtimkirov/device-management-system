<?php

namespace App\Http\Requests\Measurements;

use Illuminate\Foundation\Http\FormRequest;

class CreateMeasurementRequest extends FormRequest
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
            'temperature' => [
                'required',
                'numeric',
                'min:-30',
                'max:100',
            ],
            'device' => [
                'required',
                'integer',
                'exists:devices,id'
            ],
        ];
    }

    /**
     * Merge the request params with the URL params
     *
     * @return array
     */
    public function validationData(): array
    {
        return array_merge($this->all(), [
            'device' => $this->route('device'),
        ]);
    }
}
