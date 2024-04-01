@extends('template.base')

@section('title', 'List of Leave Requests')

@section('content')
    <div class="container mt-lg-5">
{{--        <nav class="second-navbar">--}}
{{--            <!-- Lien "Leave Category" pour les utilisateurs ayant la permission 'gestion_conge' -->--}}
{{--            @if(auth()->user()->hasRole('Administrateur'))--}}
{{--                <a href="{{ route('conges.index')}}" class="nav-item is-active">Leave Category</a>--}}
{{--            @endif--}}

{{--            <!-- Lien "Leave List" pour les utilisateurs ayant la permission 'listes_conge' -->--}}
{{--            @if(auth()->user()->hasRole('Utilisateur Interne'))--}}
{{--                <a href="{{ route('conges.index')}}" class="nav-item is-active">Leave List</a>--}}
{{--            @endif--}}

{{--            <!-- Lien "Leave Requests" pour les utilisateurs ayant la permission 'voir_infos' -->--}}
{{--            @if(auth()->user()->hasRole('Administrateur'))--}}
{{--                <a href="{{ route('listes.conge')}}" class="nav-item is-active">Leave Requests</a>--}}
{{--            @endif--}}

{{--            <!-- Lien "Category Leave" pour les utilisateurs ayant la permission 'gerer_conges' -->--}}
{{--            @if(auth()->user()->hasRole('Utilisateur Interne'))--}}
{{--                <a href="{{ route('categories-conge.index')}}" class="nav-item is-active">Category Leave</a>--}}
{{--            @endif--}}
{{--        </nav>--}}
        <br><br>
        <div class="row">
            <div class="col-6">
                <a class="btn btn-primary" href="{{ route('listes.create') }}">Add a Leave</a>
            </div>
            <div class="col-6 text-right ml-auto">
                @foreach($demandesConge as $demandeConge)
                    <a href="{{ route('export.pdf',['id' => $demandeConge->id]) }}" class="btn btn-dark"> Export to PDF</a>
                @endforeach
            </div>
        </div>
        <br><br>
        <div class="card">
            <div class="card-header bg-success-subtle">
                Leave Requests Management
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Employee Name</th>
                        <th scope="col">Leave Type</th>
                        <th scope="col">Start Date</th>
                        <th scope="col">End Date</th>
                        <th scope="col">Number of Days</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($demandesConge as $demande)
                        <tr>
                            <td>{{ $demande->id }}</td>
                            <td>{{ $demande->employees->nom }} {{ $demande->employees->prenom }}</td>
                            <td>{{ $demande->typeConge->type_conge }}</td>
                            <td>{{ $demande->date_debut }}</td>
                            <td>{{ $demande->date_fin }}</td>
                            <td>{{ $demande->nombre_jour }}</td>
                            <td>
                                <span class="badge
                                    @if($demande->statut === 'Accepted')
                                        bg-success
                                    @elseif($demande->statut === 'Rejected')
                                        bg-danger
                                    @else
                                        bg-info
                                    @endif">
                                    {{ $demande->statut }}
                                </span>
                            </td>                            <td>
                                <a href="{{ route('listes.edit', $demande->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                                <form action="{{ route('listes.destroy', $demande->id) }}" method="post" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this leave request?');"><i class="bi bi-trash"></i></button>
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
