@extends('template.base')

@section('title', 'My Leave Requests')

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

        <br><br>
        <div class="card">
            <div class="card-header bg-success-subtle">
                Dashboard
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Type of leave</th>
                        <th>Authorized days</th>
                        <th>Payment Status</th>
                        <th>Days used</th>
                        <th>Days remaining</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($gestionConges as $gestionConge)
                        <tr>
                            <td>{{ $gestionConge->type_conge }}</td>
                            <td>{{ $gestionConge->jours_autorise }}</td>
                            <td>
                                @if($gestionConge->paiement == 'paid')
                                    <span class="badge badge-success">Paid</span>
                                @else
                                    <span class="badge badge-warning">Unpaid</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $joursUtilises = isset($demandesConges) ? $demandesConges->where('idType_conge', $gestionConge->id)->sum('nombre_jour') : 0;
                                @endphp
                                {{ $joursUtilises }}
                            </td>
                            <td>
                                @if(isset($demandesConges))
                                    {{ $gestionConge->jours_autorise - $joursUtilises }}
                                @else
                                    Jours non disponibles
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
@endsection
