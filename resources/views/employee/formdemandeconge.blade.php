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
                <form method="post" action="{{ route($demandeConge->exists ? 'demande_conge.update' : 'demande_conge.store', $demandeConge) }}" enctype="multipart/form-data">
                    @csrf
                    @method($demandeConge->exists ? 'put' : 'post')

                    <input type="hidden" name="idEmployee" value="{{ $demandeConge->idEmployee }}">
                    <input type="hidden" name="idType_conge" value="{{ $demandeConge->idType_conge }}">

                    <!-- Employé -->
                    <div class="mb-3 row">
                        <label for="idEmployee" class="col-md-4 col-form-label text-md-end text-start">Employee</label>
                        <div class="col-md-6">
                            <select class="form-control" id="idEmployee" name="idEmployee" required>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}" {{ $employee->id == $demandeConge->idEmployee ? 'selected' : '' }}>
                                        {{ $employee->prenom }} {{ $employee->nom }} <!-- Remplacez name par le nom de la colonne correspondant au nom de l'employé -->
                                    </option>
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
                            <input type="date" class="form-control @error('date_debut') is-invalid @enderror" id="date_debut" name="date_debut" value="{{ $demandeConge->date_debut }}" required>
                            @error('date_debut')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Date de fin -->
                    <div class="mb-3 row">
                        <label for="date_fin" class="col-md-4 col-form-label text-md-end text-start">End Date</label>
                        <div class="col-md-6">
                            <input type="date" class="form-control @error('date_fin') is-invalid @enderror" id="date_fin" name="date_fin" value="{{ $demandeConge->date_fin }}" required>
                            @error('date_fin')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Nombre de jours -->
                    <div class="mb-3 row">
                        <label for="nombre_jour" class="col-md-4 col-form-label text-md-end text-start">Number of Days</label>
                        <div class="col-md-6">
                            <input type="number" class="form-control @error('nombre_jour') is-invalid @enderror" id="nombre_jour" name="nombre_jour" value="{{ $demandeConge->nombre_jour }}" required>
                            @error('nombre_jour')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Statut -->
                    <div class="mb-3 row">
                        <label for="statut" class="col-md-4 col-form-label text-md-end text-start">Status</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control @error('statut') is-invalid @enderror" id="statut" name="statut" value="{{ $demandeConge->statut }}" required>
                            @error('statut')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Téléphone -->
                    <div class="mb-3 row">
                        <label for="telephone" class="col-md-4 col-form-label text-md-end text-start">Telephone</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control @error('telephone') is-invalid @enderror" id="telephone" name="telephone" value="{{ $demandeConge->employee->telephone }}" required>
                            @error('telephone')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Boutons de soumission -->
                    <div class="modal-footer">
                        <a href="{{ route('demande_conge.index') }}" class="btn btn-outline-secondary">Close</a>
                        <button type="submit" class="btn btn-primary">{{ $demandeConge->exists ? "Edit" : "Add" }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
<script>
    // Fonction pour calculer le nombre de jours entre deux dates
    function calculateDays() {
        var startDate = new Date(document.getElementById("date_debut").value);
        var endDate = new Date(document.getElementById("date_fin").value);
        var timeDiff = Math.abs(endDate.getTime() - startDate.getTime());
        var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
        document.getElementById("nombre_jour").value = diffDays;
    }

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

    // Écouteurs d'événements pour les changements de dates et de sélection d'employé
    document.getElementById("date_debut").addEventListener("change", calculateDays);
    document.getElementById("date_fin").addEventListener("change", calculateDays);
    document.getElementById("idEmployee").addEventListener("change", prefillPhone);
</script>
