<header>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid d-flex flex-row justify-content-around align-items-center">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" width="40" height="40" class="d-inline-block">
                <span class="align-middle fs-5">{{ config('app.name', 'Laravel') }} </span>
            </a>
            <button class="d-md-none navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="input-group d-none d-md-flex align-self-center w-50">
                <form class="column d-md-flex align-self-center align-items-center justify-content-center form-inline" action="{{ url('/search') }}" style="width:80%">
                    <select class ="form-control w-25" id="type" name="type" aria-label="Default select example">
                        <option value="name">Name</option>
                        <option value="tag">Tag</option>
                    </select>
                    <input type="search" class="form-control" id="search" name="query" placeholder="Search Event" aria-label="Search" aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                    </button>
                </form>
            </div>
            @if (Auth::user() != null)
            @if (Auth::user()->admin != null)
            <a class="btn btn-outline-primary" href="{{ url('/admin') }}">Admin</a>
            @endif
            @endif
            <div class="d-none d-md-flex align-items-baseline">
                @if (Auth::check())
                <a id="bell"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-bell me-2" viewBox="0 0 16 16">
                <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zM8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z"/>
                </svg></a>
                <a class="text-decoration-none" href="{{ url('/profile', Auth::id()) }}"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person align-self-center" viewBox="0 0 16 16">
                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                </svg>
                <span class="pt-1">{{ Auth::user()->name }}</span></a>
                <a class="btn btn-ligth" href="{{ url('/logout') }}">Logout</a>
                @else
                <a class="btn btn-dark me-3 visually-lg-hidden" style="--bs-btn-padding-y: .60rem; --bs-btn-padding-x: 2rem; --bs-btn-font-size: .90rem;" href="{{ url('/login') }}"> LOG IN</a>
                <a class="btn btn-secondary visually-lg-hidden" style="--bs-btn-padding-y: .60rem; --bs-btn-padding-x: 2rem; --bs-btn-font-size: .90rem;" href="{{ url('/register') }}"> SIGN UP </a>
                @endif
            </div>
        </div>
    </nav>
</header>