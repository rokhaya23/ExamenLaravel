@extends('template.base')

@section('title', 'List of Employee')

@section('content')
    <div class="container mt-lg-5">

        <a class="btn btn-primary" href="{{ route('employees.create') }}">Add a employee</a>
        <br>
        <br>

        <div class="card">
            <div class="card-header bg-success-subtle">LIST OF USERS</div>
            <div class="card-body">
                <table class="table table-striped">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Adress</th>
                <th scope="col">Phone</th>
                <th scope="col">Job</th>
                <th scope="col">Départment</th>
                <th scope="col">Salaire</th>
                <th scope="col">Hiring Date</th>
                <th scope="col">Options</th>
            </tr>
            </thead>
            <tbody>
            @foreach($employees as $employee)
                <tr>
                    <th scope="row">{{ $employee->id }}</th>
                    <td>{{ $employee->nom }} {{ $employee->prenom }}</td>
                    <td>{{ $employee->adresse }}</td>
                    <td>{{ $employee->telephone }}</td>
                    <td>{{ $employee->poste }}</td>
                    <td>{{ $employee->departement }}</td>
                    <td>{{ $employee->salaire }}</td>
                    <td>{{ $employee->date_embauche }}</td>
                    <td>
                        <form action="{{ route('employees.destroy', $employee->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> </a>

                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this employee?');"><i class="bi bi-trash"></i> </button>

                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
