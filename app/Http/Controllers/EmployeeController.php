<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:gerer_employees', ['only' => ['index','show','create','update','store','edit','destroy']]);
    }

    public function index()
    {
        $employees = Employee::all();
        return view('employee.index', compact('employees'));
    }

    public function create()
    {
        if (auth()->user()->hasRole('Administrateur')) {

            $employee = new Employee(); // Crée une nouvelle instance de l'employé
            $roles = Role::all(); // Récupérez tous les rôles
            return view('employee.form', compact('employee','roles'));
        } else {
            abort(403);
        }
    }


    public function store(EmployeeRequest $request)
    {
        // Récupérer les données du formulaire validées
        $data = $request->validated();

        // Convertir les langues sélectionnées en JSON
        $languages = $request->input('language');
        $data['langues'] = json_encode($languages);

        // Vérifier si une photo a été téléchargée
        if ($request->hasFile('photo')) {
            // Sauvegarder la photo dans le dossier public/photos
            $imagePath = $request->file('photo')->store('photos', 'public');
            // Stocker le chemin de l'image dans les données du formulaire
            $data['photo'] = $imagePath;
        }

        // Hacher le mot de passe
        $data['password'] = bcrypt($data['password']);

        // Créer un nouvel employé avec les données fournies
        $employee = Employee::create($data);

        // Attribuer le rôle approprié à l'employé
        $employee->assignRole($request->roles);


        // Rediriger avec un message de succès
        return redirect()->route('employees.index')->with('success', 'Employee added successfully.');
    }



    public function show(Employee $employee)
    {
        return view('employee.show', compact('employee'));
    }


    public function edit(Employee $employee)
    {
        $roles = Role::get();

        // Décoder le champ JSON "languages" en un tableau PHP
        $employeeLanguages = json_decode($employee->languages, true);

        return view('employee.form', compact('employee','employeeLanguages','roles'));
    }

    public function update(EmployeeRequest $request, Employee $employee)
    {
        // Récupérer les données du formulaire validées
        $data = $request->validated();

        // Vérifier si un nouveau mot de passe a été fourni
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            $data = $request->except('password');
        }

        // Vérifier si le champ "language" est présent dans les données validées du formulaire
        if ($request->has('language')) {
            // Mettre à jour les langues avec celles sélectionnées dans le formulaire
            $data['languages'] = json_encode($request->language);
        } else {
            // Garder les langues existantes si rien n'a été sélectionné dans le formulaire
            $data['languages'] = $employee->languages;
        }

        // Vérifier si une nouvelle photo a été téléchargée
        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo s'il y en a une
            if ($employee->photo) {
                Storage::disk('public')->delete($employee->photo);
            }
            // Sauvegarder la nouvelle photo dans le dossier public/photos
            $imagePath = $request->file('photo')->store('photos', 'public');
            // Stocker le chemin de la nouvelle image dans les données du formulaire
            $data['photo'] = $imagePath;
        }

        // Mettre à jour les données de l'employé avec les données fournies
        $employee->update($data);

        // Mettre à jour le rôle de l'employé si nécessaire
        $employee->syncRoles($request->roles);

        // Rediriger avec un message de succès
        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }

}
