<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UtilisateurRequest extends FormRequest
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
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'date_naissance' => 'required|date',
            'adresse' => 'required|string',
            'telephone' => 'required|string',
            'poste' => 'required|string',
            'sexe' => 'required|string',
            'email' => 'required|email|unique:employees,email',
            'banque' => 'required|string',
            'numero_compte' => 'required|string',
            'CNI' => 'required|string|min:13|max:13|unique:employees,CNI',
            'password' => 'required|string|min:8',
            'departement' => 'required|string',
            'salaire' => 'required|numeric',
            'date_embauche' => 'required|date',
            'langues' => 'nullable|string',
            'situation_matrimonial' => 'nullable|string',
        ];
    }
}
