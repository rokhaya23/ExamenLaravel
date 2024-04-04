<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Boxicons CSS -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('css/style2.css')}}">
    <link href="{{ asset('css/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/3.6.95/css/materialdesignicons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css">

    <!-- jQuery library -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>@yield('title')</title>
</head>

<body>

<!-- Sidebar -->
<div class="sidebar">
    <a href="#" class="logo">
        <i class='bx bx-code-alt'></i>
        <div class="logo-name"><span>Asmr</span>Prog</div>
    </a>
    <ul class="side-menu">
        @auth

            <li class="active"><a href="{{route('dashboard')}}"><i class='bx bxs-dashboard'></i>Dashboard</a></li>

            <!-- Lien Employee pour les utilisateurs ayant la permission 'manage_employees' -->
            @can('gerer_employees')
                <li class="active"><a href="{{ route('employees.index')}}"><i class='bx bx-analyse'></i>Employee</a></li>
            @endcan

            <!-- Lien Contract pour les utilisateurs ayant la permission 'manage_contracts' -->
            @can('gerer_contrats')
                <li class="active"><a href="{{ route('contrats.index')}}"><i class='bx bx-message-square-dots'></i>Contract</a></li>
            @endcan

            <!-- Lien Leave Management pour les utilisateurs ayant la permission 'manage_leave' -->
            @can('category_conges')
                <li class="active"><a href="{{ route('conges.index')}}"><i class='bx bx-group'></i>Leave Category</a></li>
            @endcan

            @can('gerer_conges')
                <li class="active"><a href="{{ route('categories-conge.index')}}"><i class='bx bx-group'></i>Category Leave</a></li>
            @endcan

            @can('gerer_roles')
                <li class="active"><a href="{{ route('roles.index')}}"><i class='bx bx-group'></i>Role</a></li>
            @endcan

            @can('voir_infos')
                <li class="active"><a href="{{ route('listes.index') }}"><i class='bx bx-group'></i>Leave Request</a></li>
            @endcan

            @can('listes_conge')
                <li class="active"><a href="{{ route('mes_demandes_conge') }}"><i class='bx bx-group'></i>Leave List</a></li>
            @endcan
            <li class="active"><a href="{{ route('documents.index') }}"><i class='bx bx-cog'></i>Document</a></li>
        @endauth
    </ul>
    <ul class="side-menu">
        <li>
            <form id="logout-form" action="{{ route('logout')}}" method="POST" >
                @csrf
                <button type="submit" class="btn btn-link text-danger">
                    <i class='bx bx-log-out-circle'></i>
                    Logout
                </button>
            </form>
        </li>
    </ul>
</div>
<!-- End of Sidebar -->

<!-- Main Content -->
<div class="content">
    <!-- Navbar -->
    <nav>
        <i class='bx bx-menu'></i>
        <form action="#">
            <div class="form-input">
                <input type="search" placeholder="Search...">
                <button class="search-btn" type="submit"><i class='bx bx-search'></i></button>
            </div>
        </form>
        <input type="checkbox" id="theme-toggle" hidden>
        <label for="theme-toggle" class="theme-toggle"></label>
        <a href="#" class="notif">
            <i class='bx bx-bell'></i>
            <span class="count">12</span>
        </a>
        <a href="#" class="profile">
            <img src="{{ asset('images/logo.png')}}">
        </a>
    </nav>
    <!-- End of Navbar -->

    <main>
        @yield('content')
    </main>

    @include('auth.flash')
</div>
<!-- End of Main Content -->

<!-- Bootstrap and Popper.js Scripts -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Your Custom JavaScript File -->
<script src="{{ asset('js/index.js') }}"></script>
</body>

</html>
