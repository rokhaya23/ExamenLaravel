<!-- resources/views/demande_conge/form.blade.php -->

@extends('template.base')

@section('title', 'Leave Request Management')

@section('content')
    <div class="container mt-lg-5">
        <div class="card">
            <div class="card-header bg-success-subtle">
                Leave Request Form
            </div>
            <div class="card-body">
                <form method="post" action="{{ route($demandeConge->exists ? 'listes.update' : 'listes.store', $demandeConge) }}" enctype="multipart/form-data">
                    @csrf
                    @method($demandeConge->exists ? 'put' : 'post')

                    <div class="mb-3 row">
                        <label for="idEmployee" class="col-md-4 col-form-label text-md-end text-start">Employee</label>
                        <div class="col-md-6">
                            <select class="form-control" id="idEmployee" name="idEmployee" required>
                                @foreach ($employees as $employee)
                                    @if (Auth::user()->hasRole('Utilisateur Interne') && $employee->id == Auth::user()->id)
                                        <!-- Si l'utilisateur est un utilisateur interne, afficher uniquement son propre nom -->
                                        <option value="{{ $employee->id }}" selected>
                                            {{ $employee->prenom }} {{ $employee->nom }}
                                        </option>
                                    @elseif (!Auth::user()->hasRole('Utilisateur Interne'))
                                        <!-- Si l'utilisateur n'est pas un utilisateur interne, afficher tous les noms des employés -->
                                        <option value="{{ $employee->id }}" {{ $employee->id == $demandeConge->idEmployee ? 'selected' : '' }}>
                                            {{ $employee->prenom }} {{ $employee->nom }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- Type de congé -->
                    <div class="mb-3 row">
                        <label for="idType_conge" class="col-md-4 col-form-label text-md-end text-start">Leave Type</label>
                        <div class="col-md-6">
                            <select class="form-control" id="idType_conge" name="idType_conge" required>
                                @foreach ($typesConge as $typeConge)
                                    <option value="{{ $typeConge->id }}" {{ $typeConge->id == $demandeConge->idType_conge ? 'selected' : '' }}>
                                        {{ $typeConge->type_conge }} <!-- Remplacez type_conge par le nom de la colonne correspondant au type de congé -->
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Date de début -->
                    <div class="mb-3 row">
                        <label for="date_debut" class="col-md-4 col-form-label text-md-end text-start">Start Date</label>
                        <div class="col-md-6">
                            <input type="date" class="form-control @error('date_debut') is-invalid @enderror" id="date_debut" name="date_debut" value="{{ old('date_debut', $demandeConge->date_debut ?? '') }}" required>
                            @error('date_debut')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Date de fin -->
                    <div class="mb-3 row">
                        <label for="date_fin" class="col-md-4 col-form-label text-md-end text-start">End Date</label>
                        <div class="col-md-6">
                            <input type="date" class="form-control @error('date_fin') is-invalid @enderror" id="date_fin" name="date_fin" value="{{ old('date_debut', $demandeConge->date_fin ?? '') }}" required>
                            @error('date_fin')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Nombre de jours -->
                    <div class="mb-3 row">
                        <label for="nombre_jour" class="col-md-4 col-form-label text-md-end text-start">Number of Days</label>
                        <div class="col-md-6">
                            <input type="number" class="form-control @error('nombre_jour') is-invalid @enderror" id="nombre_jour" name="nombre_jour" value="{{ $demandeConge->nombre_jour ?? ''}}" required>
                            @error('nombre_jour')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Statut (uniquement pour les administrateurs) -->
                    @if (Auth::user()->hasRole('Administrateur'))
                        <div class="mb-3 row">
                            <label for="statut" class="col-md-4 col-form-label text-md-end text-start">Status</label>
                            <div class="col-md-6">
                                <select class="form-control" id="statut" name="statut" required >
                                    <option value="Pending" {{ $demandeConge->statut == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Accepted" {{ $demandeConge->statut == 'Accepted' ? 'selected' : '' }}>Accepted</option>
                                    <option value="Rejected" {{ $demandeConge->statut == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                        </div>
                    @endif

                    <!-- Téléphone -->
                    <div class="mb-3 row">
                        <label for="telephone" class="col-md-4 col-form-label text-md-end text-start">Telephone</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control @error('telephone') is-invalid @enderror" id="telephone" name="telephone" value="{{ $demandeConge->telephone }}" required>
                            @error('telephone')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Boutons de soumission -->
                    <div class="modal-footer">
                        <a href="{{ route('listes.index') }}" class="btn btn-outline-secondary">Close</a>
                        <button type="submit" class="btn btn-primary">{{ $demandeConge->exists ? "Edit" : "Add" }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        // Fonction pour pré-remplir le champ du téléphone en fonction de l'employé sélectionné
        function prefillPhone() {
            var employeeId = document.getElementById("idEmployee").value;
            // Effectuez une requête AJAX pour récupérer le numéro de téléphone de l'employé en fonction de son ID
            // Par exemple :
            fetch('/getPhoneNumber/' + employeeId)
                .then(response => response.json())
                .then(data => {
                    document.getElementById("telephone").value = data.phoneNumber;
                });
        }

        // Écouteur d'événement pour le changement de sélection de l'employé
        document.getElementById("idEmployee").addEventListener("change", prefillPhone);

        // Appel initial de la fonction prefillPhone() pour pré-remplir le champ du téléphone si un employé est déjà sélectionné
        prefillPhone();

        function calculateDays() {
            var startDate = new Date(document.getElementById("date_debut").value);
            var endDate = new Date(document.getElementById("date_fin").value);
            var timeDiff = Math.abs(endDate.getTime() - startDate.getTime());
            var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
            document.getElementById("nombre_jour").value = diffDays;
        }

        // Écouteur d'événement pour le changement de la date de début
        document.getElementById("date_debut").addEventListener("change", calculateDays);

        // Écouteur d'événement pour le changement de la date de fin
        document.getElementById("date_fin").addEventListener("change", calculateDays);

        // Appel initial de la fonction calculateDays() pour mettre à jour le nombre de jours si les dates sont déjà remplies
        calculateDays();
    </script>

@endsection
