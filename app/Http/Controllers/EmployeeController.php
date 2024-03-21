<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:gerer_employee', ['only' => ['index','show','create','update','store','edit','destroy']]);
    }

    public function index()
    {
        $employees = Employee::all();
        return view('employee.index', compact('employees'));
    }

    public function create()
    {
        $employee = new Employee(); // Crée une nouvelle instance de l'employé
        return view('employee.form', compact('employee'));
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
            // Sauvegarder la photo dans le dossier public/images
            $imagePath = $request->file('photo')->store('photos', 'public');
            // Stocker le chemin de l'image dans les données du formulaire
            $data['photo'] = $imagePath;
        }

        // Hacher le mot de passe
        $data['password'] = bcrypt($data['password']);

        // Créer un nouvel employé avec les données fournies
        Employee::create($data);

        // Rediriger avec un message de succès
        return redirect()->route('employees.index')->with('success', 'Employee added successfully.');
    }



    public function show(Employee $employee)
    {
        return view('employee.show', compact('employee'));
    }


    public function edit(Employee $employee)
    {
        return view('employee.form', compact('employee'));
    }

    public function update(EmployeeRequest $request, Employee $employee)
    {
        // Récupérer les données du formulaire validées
        $data = $request->validated();

        // Vérifier si un nouveau mot de passe est fourni
        if ($request->filled('password')) {
            // Hasher le nouveau mot de passe
            $data['password'] = bcrypt($data['password']);
        }

        // Vérifier si une nouvelle photo a été téléchargée
        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo s'il y en a une
            if ($employee->photo) {
                Storage::disk('public')->delete($employee->photo);
            }
            // Sauvegarder la nouvelle photo dans le dossier public/images
            $imagePath = $request->file('photo')->store('photos', 'public');
            // Stocker le chemin de la nouvelle image dans les données du formulaire
            $data['photo'] = $imagePath;
        }

        // Mettre à jour les données de l'employé avec les données fournies
        $employee->update($data);

        // Rediriger avec un message de succès
        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }


    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
}
