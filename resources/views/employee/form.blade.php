@extends('template.base')
@section('title', 'Employee Form')

@section('content')

    <div class="container-fluid" style="margin-top: 30px;">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="card" style="border-color: blue;">
                    <div class="card-header bg-info text-white">
                        <h><b>Employe Form</b></h>
                    </div>
                    <div class="card-body" style="background-color: #e9ecef;">
                        <form method="post" action="{{ route($employee->exists ? 'employees.update' : 'employees.store', $employee) }}" enctype="multipart/form-data">
                            @csrf
                            @method($employee->exists ? 'put' : 'post')
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="prenom">First Name</label>
                                                <input type="text" class="form-control" name="prenom" id="prenom" value="{{ $employee->prenom ?? '' }}" required>
                                                <span id="available"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nom">Last Name</label>
                                                <input type="text" class="form-control" name="nom" id="nom" value="{{ $employee->nom ?? '' }}" required>
                                                <span id="available"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <legend>Gender</legend>
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="sexe" value="M" {{ $employee->sexe == 'M' ? 'checked' : '' }}>Male
                                                    </label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="sexe" value="F" {{ $employee->sexe == 'F' ? 'checked' : '' }}>Female
                                                    </label>
                                                </div>
                                            </fieldset>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="date_naissance">Dath Of Birth</label>
                                                <input type="date" class="form-control" name="date_naissance" id="date_naissance" value="{{ $employee->date_naissance ?? '' }}" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="adresse">Address</label>
                                                <textarea class="form-control" name="adresse" rows="2">{{ $employee->adresse ?? '' }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="telephone">Phone</label>
                                                <input type="text" class="form-control" name="telephone" id="telephone" value="{{ $employee->telephone ?? '' }}" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="telephone">Email</label>
                                                <input type="text" class="form-control" name="email" id="email" value="{{ $employee->email ?? '' }}" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="telephone">Password</label>
                                                <input type="password" class="form-control" name="password" id="password" >
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <fieldset class="form-group">
                                                <legend>Marital Status</legend>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="situation_matrimonial" id="divorced" value="divorced" {{ $employee->situation_matrimonial == 'divorced' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="divorced">Divorced</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="situation_matrimonial" id="widowed" value="widowed" {{ $employee->situation_matrimonial == 'widowed' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="widowed">Widowed</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="situation_matrimonial" id="never_married" value="never_married" {{ $employee->situation_matrimonial == 'never_married' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="never_married">Never married</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="situation_matrimonial" id="married" value="married" {{ $employee->situation_matrimonial == 'married' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="married">Married</label>
                                                </div>
                                            </fieldset>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="telephone">CNI</label>
                                                <input type="text" class="form-control" name="CNI" id="CNI" value="{{ $employee->CNI ?? '' }}" required>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <!--disolay image-->
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div style="text-align: center;">
                                                <img id="img-upload">
                                                <div id="tem_img">
                                                    <img src="{{ asset('images/avatar.jpg')}}" alt="" width="150px" height="180px">
                                                </div>
                                                <br><br>
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <span class="btn btn-info btn-file">
                                                            Image()<input type="file" id="photo" name="photo" onchange="previewPhoto()">
                                                        </span>
                                                    </span>
                                                    <input type="text" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="departement">Department</label>
                                                <select class="form-control" id="departement" name="departement">
                                                    <option value="">----- Choisissez un département -----</option>
                                                    <option value="Finance" {{ $employee->departement == 'Finance' ? 'selected' : '' }}>Finance</option>
                                                    <option value="Ressources Humaines" {{ $employee->departement == 'Ressources Humaines' ? 'selected' : '' }}>Ressources Humaines</option>
                                                    <option value="Développement" {{ $employee->departement == 'Développement' ? 'selected' : '' }}>Développement</option>
                                                    <option value="Marketing" {{ $employee->departement == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                                                    <option value="Ventes" {{ $employee->departement == 'Ventes' ? 'selected' : '' }}>Ventes</option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-md-12">
                                            <fieldset class="form-group">
                                                <p>Language</p>
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" class="form-check-input" name="language[]" value="English" {{ !empty($employeeLanguages ?? []) && in_array('English', $employeeLanguages ?? []) ? 'checked' : '' }}>English
                                                    </label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" class="form-check-input" name="language[]" value="French" {{ !empty($employeeLanguages ?? []) && in_array('French', $employeeLanguages ?? []) ? 'checked' : '' }}>French
                                                    </label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" class="form-check-input" name="language[]" value="Espaniol" {{ !empty($employeeLanguages ?? []) && in_array('Espaniol', $employeeLanguages ?? []) ? 'checked' : '' }}>Espaniol
                                                    </label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" class="form-check-input" name="language[]" value="Other...." {{ !empty($employeeLanguages ?? []) && in_array('Other....', $employeeLanguages ?? []) ? 'checked' : '' }}>Other....
                                                    </label>
                                                </div>
                                            </fieldset>
                                            <br><br>
                                        </div>


                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="salaire">Salary</label>
                                        <input class="form-control" type="text" id="salaire" name="salaire" value="{{ $employee->salaire ?? '' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="poste">Poste</label>
                                        <input class="form-control" type="text" id="poste" name="poste" value="{{ $employee->poste ?? '' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="date_embauche">hiring date</label>
                                        <input type="date" class="form-control" name="date_embauche" id="date_embauche" value="{{ $employee->date_embauche ?? '' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="banque">Bank</label>
                                        <select class="form-select" id="banque" name="banque">
                                            <option value="">-------- Choisissez une banque ---------</option>
                                            <option value="SGBS" {{ $employee->banque == 'SGBS' ? 'selected' : '' }}>SGBS</option>
                                            <option value="Banque Islamique" {{ $employee->banque == 'Banque Islamique' ? 'selected' : '' }}>Banque Islamique</option>
                                            <option value="BOA" {{ $employee->banque == 'BOA' ? 'selected' : '' }}>Banque Of Africa</option>
                                            <option value="Orabank" {{ $employee->banque == 'Orabank' ? 'selected' : '' }}>Orabank</option>
                                            <option value="CBAO" {{ $employee->banque == 'CBAO' ? 'selected' : '' }}>CBAO</option>
                                            <option value="BICIS" {{ $employee->banque == 'BICIS' ? 'selected' : '' }}>BICIS</option>
                                            <option value="Coris Bank" {{ $employee->banque == 'Coris Bank' ? 'selected' : '' }}>Coris Bank</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="numero_compte">Account Number</label>
                                        <input type="text" class="form-control" name="numero_compte" id="numero_compte" value="{{ $employee->numero_compte ?? '' }}">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="roles" class="col-md-4 col-form-label text-md-end text-start">Roles</label>
                                    <div class="col-md-6">
                                        <select class="form-select @error('roles') is-invalid @enderror" multiple aria-label="Roles" id="roles" name="roles[]">
                                            @forelse ($roles as $role)
                                                @unless($role == 'Administrateur' && !Auth::user()->hasRole('Administrateur'))
                                                    <option value="{{ $role->name }}" {{ in_array($role->name, old('roles') ?? $employee->roles->pluck('name')->toArray()) ? 'selected' : '' }}>
                                                        {{ $role->name }}
                                                    </option>
                                                @endunless
                                            @empty
                                            @endforelse
                                        </select>
                                        @if ($errors->has('roles'))
                                            <span class="text-danger">{{ $errors->first('roles') }}</span>
                                        @endif
                                    </div>
                                </div>


                                <div class="col-md-12" style="text-align: center;">
                                    <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary">Close</a>
                                    <button type="submit" class="btn btn-primary">{{ $employee->exists ? "Edit" : "Add" }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <br><br>
            </div>

        </div>
    </div>

    <script>
        function previewPhoto() {
            var preview = document.querySelector('#tem_img img'); // Sélectionner l'élément img à l'intérieur de #tem_img
            var file = document.querySelector('#photo').files[0];
            var reader = new FileReader();

            reader.onloadend = function () {
                preview.src = reader.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = "";
            }
        }
    </script>
@endsection
