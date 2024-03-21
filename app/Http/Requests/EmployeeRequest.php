<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|string|max:255',
            'poste' => 'required|string|max:255',
            'sexe' => 'required|in:M,F',
            'email' => 'required|string|email|max:255|unique:employees,email',
            'banque' => 'required|string|max:255',
            'numero_compte' => 'required|string|max:255',
            'CNI' => 'required|string|max:13|unique:employees,CNI',
            'password' => 'required|string|min:8',
            'departement' => 'required|string|max:255',
            'salaire' => 'required|numeric|min:0',
            'date_embauche' => 'required|date',
            'situation_matrimonial' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'language' => 'required|array',
        ];
    }
}
