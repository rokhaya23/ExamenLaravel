@extends('template.base')

@section('title', 'List of Leaves')

@section('content')
    <div class="container mt-lg-5">

{{--        <nav class="second-navbar">--}}
{{--            <!-- Lien "Leave Category" pour les utilisateurs ayant la permission 'gestion_conge' -->--}}
{{--            @if(auth()->user()->hasRole('Administrateur'))--}}
{{--            <a href="{{ route('conges.index')}}" class="nav-item is-active">Leave Category</a>--}}
{{--            @endif--}}

{{--            <!-- Lien "Leave List" pour les utilisateurs ayant la permission 'listes_conge' -->--}}
{{--            @if(auth()->user()->hasRole('Utilisateur Interne'))--}}
{{--            <a href="{{ route('conges.index')}}" class="nav-item is-active">Leave List</a>--}}
{{--            @endif--}}

{{--            <!-- Lien "Leave Requests" pour les utilisateurs ayant la permission 'voir_infos' -->--}}
{{--            @if(auth()->user()->hasRole('Administrateur'))--}}
{{--            <a href="{{ route('listes.conge')}}" class="nav-item is-active">Leave Requests</a>--}}
{{--            @endif--}}

{{--            <!-- Lien "Category Leave" pour les utilisateurs ayant la permission 'gerer_conges' -->--}}
{{--            @if(auth()->user()->hasRole('Utilisateur Interne'))--}}
{{--            <a href="{{ route('categories-conge.index')}}" class="nav-item is-active">Category Leave</a>--}}
{{--            @endif--}}
{{--        </nav>--}}

        <br><br>

        <a class="btn btn-primary" href="{{ route('conges.create') }}">Add a Category</a>
        <br><br>
        <div class="card">
            <div class="card-header bg-success-subtle">List of Leaves</div>
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Leave Type</th>
                        <th scope="col">Payment</th>
                        <th scope="col">Allowed Days</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($conges as $conge)
                        <tr>
                            <td>{{ $conge->id }}</td>
                            <td>{{ $conge->type_conge }}</td>
                            <td>
                                <span class="badge {{ $conge->paiement === 'paid' ? 'bg-success' : 'bg-warning' }}">{{ $conge->paiement }}</span>
                            </td>
                            <td>{{ $conge->jours_autorise }}</td>
                            <td>
                                <form action="{{ route('conges.destroy', $conge->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('conges.edit', $conge->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> </a>
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this leave?');"><i class="bi bi-trash"></i> </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <script>
                const indicator = document.querySelector('.nav-indicator');
                const items = document.querySelectorAll('.nav-item');

                function handleIndicator(el) {
                    items.forEach(item => {
                        item.classList.remove('is-active');
                    });

                    const elementColor = el.dataset.activeColor;
                    const target = el.dataset.target;

                    indicator.style.width = `${el.offsetWidth}px`;
                    indicator.style.backgroundColor = elementColor;
                    indicator.style.left = `${el.offsetLeft}px`;

                    el.classList.add('is-active');
                }

                items.forEach(item => {
                    item.addEventListener('click', e => {
                        handleIndicator(e.target);
                    });
                });
            </script>

@endsection
