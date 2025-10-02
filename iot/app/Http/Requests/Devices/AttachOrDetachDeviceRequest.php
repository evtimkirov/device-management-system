<?php

namespace App\Http\Requests\Devices;

use Illuminate\Foundation\Http\FormRequest;

class AttachOrDetachDeviceRequest extends FormRequest
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
            'user_id' => ['required', 'exists:users,id'],
            'device_id' => ['required', 'exists:devices,id'],
        ];
    }

    /**
     * Merge the request params with the URL params
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => $this->route('user'),
            'device_id' => $this->route('device'),
        ]);
    }
}
