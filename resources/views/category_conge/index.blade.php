@extends('template.base')

@section('title', 'My Leave Requests')

@section('content')
    <div class="container mt-lg-5">
        <nav class="second-navbar">
            @can('voir_infos')
                <a href="{{ route('listes.index')}}" class="nav-item is-active">Leave List</a>
            @endcan
            @can('category_conges')
                <a href="{{ route('categories-conge.index')}}" class="nav-item is-active">Category Leave</a>
            @endcan
        </nav>
        <br><br>
        <div class="card">
            <div class="card-header bg-success-subtle">
                My Leave Requests
            </div>
            <div class="card-body">
                <table>
                    <tr>
                        <th>Type of Leave</th>
                        <th>Payment</th>
                        <th>Allowed Days</th>
                        <th>Used Days</th>
                        <th>Remaining Days</th>
                    </tr>
                    @foreach($conges as $conge)
                        <tr>
                            <td>{{ $conge->idType_conge }}</td>
                            <td>{{ $conge->date_debut }}</td>
                            <td>{{ $conge->date_fin }}</td>
                            <td>{{ $conge->nombre_jour }}</td>
                            <td>{{ $conge->statut }}</td>
                            @foreach($gestionConges as $gestionConge)
                                @if($gestionConge->type_conge == $conge->idType_conge)
                                    <td>{{ $gestionConge->paiement }}</td>
                                    <td>{{ $gestionConge->jours_autorise }}</td>
                                    <td>{{ $conges->where('idType_conge', $conge->idType_conge)->sum('nombre_jour') }}</td>
                                    <td>{{ $remainingDays[$conge->idType_conge] }}</td>
                                    @break
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
