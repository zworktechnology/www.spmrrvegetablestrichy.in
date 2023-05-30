@extends('layout.backend.guest')

@section('content')
    <div class="error-box error-page">
        <h1>500</h1>
        <h3 class="h2 mb-3"><i class="fas fa-exclamation-circle"></i> Oops! Something went wrong</h3>
        <p class="h4 font-weight-normal">I have none of these roles</p>
        <a class="dropdown-item logout btn btn-primary" href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
@endsection
