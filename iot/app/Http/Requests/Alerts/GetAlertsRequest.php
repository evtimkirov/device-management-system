<?php

namespace App\Http\Requests\Alerts;

use Illuminate\Foundation\Http\FormRequest;

class GetAlertsRequest extends FormRequest
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
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'user_id' => [
                'required',
                'integer',
                'exists:users,id'
            ],
        ];
    }

    /**
     * Merge the request params with the URL params
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge(['user_id' => $this->route('user')]);
    }
}
