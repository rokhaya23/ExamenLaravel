<?php

namespace App\Http\Controllers;

use App\Http\Requests\UtilisateurRequest;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UtilisateurController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:gerer_user', ['only' => ['index','show','create','update','store','edit','destroy']]);
    }

    public function index()
    {
        $users = Utilisateur::all();
        $roles = Role::get(); // Définir la variable $roles
        return view('utilisateur.index', compact('users','roles'));
    }

    public function create()
    {
        if (auth()->user()->hasRole('Administrateur')) {
            $user = new Utilisateur();

            $roles = Role::all(); // Récupérez tous les rôles
            $permissions = Permission::all(); // Ajout de cette ligne pour récupérer les permissions
            return view('utilisateur.form', compact('user','roles','permissions'));
        } else {
            abort(403);
        }
    }

    public function store(UtilisateurRequest $request)
    {
        $input = $request->validated();
        $input['password'] = Hash::make($request->password);

        $photoPath = $request->file('photo')->store('public/photos');
        $input['photo'] = basename($photoPath);

        $user = Utilisateur::create($input);
        $user->syncRoles($request->roles);
        $user->syncPermissions($request->permissions);

        return redirect()->route('users.index')->with('success', 'Utilisateur ajouté avec succès.');
    }



    public function edit(Utilisateur $user)
    {
        $roles = Role::get();
        $permissions = Permission::get();
        return view('utilisateur.form', compact('user', 'roles', 'permissions'));
    }

    public function update(UtilisateurRequest $request, Utilisateur $user)
    {
        $input = $request->all();

        // Vérifier si un nouveau mot de passe a été fourni
        if ($request->filled('password')) {
            $input['password'] = Hash::make($request->password);
        } else {
            $input = $request->except('password');
        }

        // Mettre à jour les autres champs de l'utilisateur
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $input['photo'] = basename($path);
        }

        // Appliquer les modifications à l'utilisateur
        $user->update($input);

        // Synchroniser les rôles et les permissions
        $user->syncRoles($request->roles);
        $user->syncPermissions($request->permissions);

        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour avec succès.');
    }



    public function destroy(Utilisateur $user)
    {
        if ($user->hasRole('Administrateur') || $user->id == auth()->user()->id)
        {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
        }

        $user->syncRoles([]);
        $user->syncPermissions([]);

        $photoPath = 'public/photos/' . $user->photo;
        Storage::delete([$photoPath]);

        $user->delete();
        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }

    public function show(Utilisateur $user)
    {
        return view('utilisateur.show', compact('user'));
    }
}
