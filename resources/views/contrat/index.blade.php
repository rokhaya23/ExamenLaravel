@extends('template.base')

@section('title', 'List of Contracts')

@section('content')
    <div class="container mt-lg-5">

        <a class="btn btn-primary" href="{{ route('contrats.create') }}">Add a contract</a>
        <br>
        <br>

        <div class="card">
            <div class="card-header bg-success-subtle">
                List of Contracts
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Contract Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
{{--                        <th>Automatic Renewal</th>--}}
                        <th>Option</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($contrats as $contract)
                        <tr>
                            <td>{{ $contract->employee->nom }} {{ $contract->employee->prenom }}</td>
                            <td>{{ $contract->type_contrat }}</td>
                            <td>{{ $contract->date_debut }}</td>
                            <td>{{ $contract->date_fin }}</td>
{{--                            <td>{{ $contract->renouvellement_auto ? 'Yes' : 'No' }}</td>--}}
                            <td>
                                <form action="{{ route('contrats.destroy', $contract->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('contrats.edit', $contract->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> </a>
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this contract?');"><i class="bi bi-trash"></i> </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
