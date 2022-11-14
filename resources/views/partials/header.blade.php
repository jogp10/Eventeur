<header>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid d-flex flex-row justify-content-around align-items-center">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" width="40" height="40" class="d-inline-block">
                <span class="align-middle fs-5">{{ config('app.name', 'Laravel') }} </span>
            </a>
            <div class="d-none d-sm-flex w-50 input-group align-self-center">
                <form class ="d-none d-sm-flex w-100 align-self-center form-inline" type = "get" action ="{{ url('/search') }}">
                    <input type="search" class="form-control" name = "query" placeholder="Search Event" aria-label="Search"
                        aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><svg
                        xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-search" viewBox="0 0 16 16">
                        <path
                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                    </button>
                </form>
            </div>
            <div class="d-none d-md-flex align-items-baseline">
                @if (Auth::check())
                <a class="text-decoration-none" href="{{ url('/profile') }}"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                    fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                    <path
                        d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                </svg>
                <span class="">{{ Auth::user()->name }}</span></a>
                <a type="button" class="btn btn-ligth" href="{{ url('/logout') }}">Logout</a>
                @else
                <a type="button" class="btn btn-dark me-3" style="--bs-btn-padding-y: .60rem; --bs-btn-padding-x: 2rem; --bs-btn-font-size: .90rem;" href="{{ url('/login') }}"> LOG IN</a>
                <a type="button" class="btn btn-secondary" style="--bs-btn-padding-y: .60rem; --bs-btn-padding-x: 2rem; --bs-btn-font-size: .90rem;" href="{{ url('/register') }}"> SIGN UP </a>
                @endif
            </div>
        </div>
    </nav>
</header>