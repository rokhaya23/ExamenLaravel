@extends('template.base')

@section('title', 'Leave Management')

@section('content')

    <div class="container mt-lg-5">
        <div class="card">
            <div class="card-header bg-success-subtle">
                Leave Management
            </div>
            <div class="card-body">
                <form method="post" action="{{ $conge->exists ? route('conges.update', $conge->id) : route('conges.store') }}" enctype="multipart/form-data">
                    @csrf
                    @if ($conge->exists)
                        @method('PUT')
                    @endif

                    <div class="mb-3 row">
                        <label for="type_conge" class="col-md-4 col-form-label text-md-end text-start">Leave Type</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control @error('type_conge') is-invalid @enderror" id="type_conge" name="type_conge" value="{{ $conge->type_conge }}" required>
                            @if ($errors->has('type_conge'))
                                <span class="text-danger">{{ $errors->first('type_conge') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="paiement" class="col-md-4 col-form-label text-md-end text-start">Payment</label>
                        <div class="col-md-6">
                            <select class="form-control" id="paiement" name="paiement" required>
                                <option value="paid" {{ old('paiement', $conge->paiement) === 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="unpaid" {{ old('paiement', $conge->paiement) === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            </select>
                            @if ($errors->has('paiement'))
                                <span class="text-danger">{{ $errors->first('paiement') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="jours_autorise" class="col-md-4 col-form-label text-md-end text-start">Allowed Days</label>
                        <div class="col-md-6">
                            <input type="number" class="form-control @error('jours_autorise') is-invalid @enderror" id="jours_autorise" name="jours_autorise" value="{{ $conge->jours_autorise }}" required>
                            @if ($errors->has('jours_autorise'))
                                <span class="text-danger">{{ $errors->first('jours_autorise') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="modal-footer">
                        <a href="{{ route('conges.index') }}" class="btn btn-outline-secondary">Close</a>
                        <button type="submit" class="btn btn-primary">{{ $conge->exists ? "Edit" : "Add" }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
