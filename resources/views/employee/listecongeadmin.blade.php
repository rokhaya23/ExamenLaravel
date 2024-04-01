@extends('template.base')

@section('title', 'Leave Requests Management')

@section('content')
    <div class="container mt-lg-5">
        <div class="card">
            <div class="card-header bg-success-subtle">
                Leave Requests List
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Leave Type</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Number of Days</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($demandesConge as $demandeConge)
                            <tr>
                                <td>{{ $demandeConge->employees->prenom }} {{ $demandeConge->employees->nom }}</td>
                                <td>{{ $demandeConge->typeConge->type_conge }}</td>
                                <td>{{ $demandeConge->date_debut }}</td>
                                <td>{{ $demandeConge->date_fin }}</td>
                                <td>{{ $demandeConge->nombre_jour }}</td>
                                <td>
                                    @if($demandeConge->statut=='Pending')
                                        <a href="/valider_demande_conges/{{$demandeConge->id}}" class="btn btn-outline-secondary  ">
                                            <i class="las la-check-circle"></i>
                                        </a>
                                        <a href="/refuser_demande_conges/{{$demandeConge->id}}" class="btn btn-outline-danger ">

                                            <i class="las la-times-circle"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
