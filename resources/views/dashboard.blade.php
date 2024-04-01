@extends('template.base')

@section('title', 'Dashboard')

@section('content')
    <div class="container">
        <h1>Dashboard</h1>
        <div class="row">
            <div class="col-md-6">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total number of employee <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                                <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/>
                            </svg></h5>
                        <p class="card-text">{{ $nombreEmployees }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total number of department <!-- Utilisation de l'icône Bootstrap pour les départements -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-building-fill" viewBox="0 0 16 16">
                                <path d="M.5 1.5A.5.5 0 0 1 1 .5h14a.5.5 0 0 1 .5.5v13a.5.5 0 0 1-.5.5h-14a.5.5 0 0 1-.5-.5v-13zm1 .5v12h13v-12H1z"/>
                                <path d="M8 14.5V5h4v9.5H8z"/>
                                <path fill-rule="evenodd" d="M1 3.5A.5.5 0 0 1 1.5 3h2a.5.5 0 0 1 .5.5V5H1V3.5zm0-1V1a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5v1H1z"/>
                                <path fill-rule="evenodd" d="M2 5.5A.5.5 0 0 1 2.5 5h1a.5.5 0 0 1 .5.5V7H2v-1.5zm0-1V4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v.5H2z"/>
                            </svg>
                        </h5>
                        <p class="card-text">{{ $nombreDepartements }}</p>
                    </div>
                </div>
            </div>
        </div>


@endsection
