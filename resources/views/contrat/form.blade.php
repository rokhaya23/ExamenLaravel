@extends('template.base')

@section('title', $contrat->exists ? 'Edit Contrat' : 'Add Contrat Form')

@section('content')

    <div class="container mt-lg-5">
        <div class="card">
            <div class="card-header bg-success-subtle">
                {{ $contrat->exists ? "Edit Contrat" : "Add Contrat Form" }}
            </div>
            <div class="card-body">
                <form method="post" action="{{ $contrat->exists ? route('contrats.update', $contrat) : route('contrats.store') }}" enctype="multipart/form-data">
                    @csrf
                    @if($contrat->exists)
                        @method('put')
                    @endif

                    <div class="form-group">
                        <label for="employee">Employee:</label>
                        <select class="form-control" id="employee" name="idEmployee">
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" {{ $employee->id == $contrat->idEmployee ? 'selected' : '' }}>{{ $employee->prenom }} {{ $employee->nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="type_contrat">Contract Type:</label>
                        <select class="form-control" id="type_contrat" name="type_contrat">
                            <option>----choose contract----</option>
                            <option value="CDD" {{ $contrat->type_contrat === 'CDD' ? 'selected' : '' }}>CDD</option>
                            <option value="CDI" {{ $contrat->type_contrat === 'CDI' ? 'selected' : '' }}>CDI</option>
                            <!-- Ajoutez d'autres options au besoin -->
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="date_debut">Start Date:</label>
                        <input type="date" class="form-control" id="date_debut" name="date_debut" value="{{ $contrat->date_debut }}">
                    </div>

                    <div class="form-group">
                        <label for="date_fin">End Date:</label>
                        <input type="date" class="form-control" id="date_fin" name="date_fin" value="{{ $contrat->date_fin }}" {{ $contrat->type_contrat === 'CDI' ? 'disabled' : '' }}>
                    </div>

                    <button type="submit" class="btn btn-primary">{{ $contrat->exists ? 'Update' : 'Add' }} Contract</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // JavaScript code to prefill the start date field with the employee's date d'embauche
        document.getElementById('employee').addEventListener('change', function() {
            var selectedEmployee = this.value;
            var employeeDateEmbauche = {!! json_encode($employees->pluck('date_embauche', 'id')->toArray()) !!}[selectedEmployee];
            if (employeeDateEmbauche) {
                document.getElementById('date_debut').value = employeeDateEmbauche;
            }
        });

        document.getElementById('type_contrat').addEventListener('change', function() {
            var typeContrat = this.value;
            var dateFinField = document.getElementById('date_fin');
            if (typeContrat === 'CDI') {
                dateFinField.value = ''; // Clear the value
                dateFinField.disabled = true;
            } else {
                dateFinField.disabled = false;
            }
        });
    </script>

@endsection
