<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProspectRequest extends FormRequest
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
        // Obtenemos el ID directamente del prospecto que viene en el parámetro de la ruta
        $prospectId = $this->route('id') ?? $this->route('prospect');

        return [
            'name' => 'required|string|max:150',
            'phone' => [
                'required',
                'string',
                'digits:10',
                Rule::unique('prospects', 'phone')->ignore($prospectId),
            ],
            'email' => 'nullable|email',
        ];
    }
}
