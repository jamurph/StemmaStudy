@extends('layouts.admin')

@section('title', 'StemmaStudy Admin')

@section('header')

<style>
    body {
        display: flex;
        min-height: 100vh;
        flex-direction: column;
        color: white;
        background: var(--dark);
    }

    main {
        flex: 1;
    }

    footer {
        background: var(--dark);
        color: var(--dark-acc);
        padding: 30px 20px 5px 20px;
    }

    footer h5 {
        color: white;
    }

    footer a {
        display: block;
        color: var(--dark-acc);
    }

    footer a:hover {
        color: white;
    }

    .copyright {
        color: var(--dark-acc);
        font-size: 12px;
    }

    .copyright a {
        display: inline-block;
    }




</style>

@endsection

@section('content')
    <div class="container py-5">
        <h1 class="text-center">Welcome, Admin</h1>
        <div class="row my-5">
            <div class="col-md-4 col-lg-3">
                <div class="metric-box p-3">
                    <h5>Total Users</h5>
                    <p class="green">{{ App\User::count() }}</p>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="metric-box p-3">
                    <h5>Total Sets</h5>
                    <p>{{ App\Set::count() }}</p>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="metric-box p-3">
                    <h5>Total Cards</h5>
                    <p class="green">{{ App\Card::count() }}</p>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="metric-box p-3">
                    <h5>Total Connections</h5>
                    <p>{{ App\Connection::count() }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection