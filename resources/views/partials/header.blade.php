<header>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid d-flex flex-row justify-content-around align-items-center">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" width="40" height="40" class="d-inline-block">
                <span class="align-middle fs-5">{{ config('app.name', 'Laravel') }} </span>
            </a>
            <button class="d-md-none navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="input-group d-none d-md-flex align-self-center w-50">
                <form class="column d-md-flex align-self-center align-items-center justify-content-center form-inline" action="{{ url('/search') }}" style="width:80%">
                    <select class="form-control w-25" id="type" name="type" aria-label="Default select example">
                        <option value="name">Name</option>
                        <option value="tag">Tag</option>
                    </select>
                    <input type="search" class="form-control" id="search" name="query" placeholder="Search Event" aria-label="Search" aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                    </button>
                    <button class="btn btn-outline-secondary" type="button" id="searchFiltersbtn" data-bs-toggle="modal" data-bs-target="#searchFilterModal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
                            <path d="M2.5 1a.5.5 0 0 1 .5.5v13a.5.5 0 0 1-1 0v-13a.5.5 0 0 1 .5-.5z" />
                            <path d="M4.5 1a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-1 0v-9a.5.5 0 0 1 .5-.5z" />
                            <path d="M6.5 1a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-1 0v-5a.5.5 0 0 1 .5-.5z" />
                            <path d="M8.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-1 0v-1a.5.5 0 0 1 .5-.5z" />
                            <path d="M10.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-1 0v-1a.5.5 0 0 1 .5-.5z" />
                            <path d="M12.5 1a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-1 0v-5a.5.5 0 0 1 .5-.5z" />
                            <path d="M14.5 1a.5.5 0 0 1 .5.5 v9a.5.5 0 0 1-1 0v-9a.5.5 0 0 1 .5-.5z" />
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
                <a id="bell"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-bell" viewBox="0 0 16 16">
                        <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zM8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z" />
                    </svg>
                    <span class="badge rounded-pill bg-danger me-3" id="notification-count">{{Auth::user()->user->notifications->where('seen', false)->count()}}</span>
                </a>
                <a class="text-decoration-none" href="{{ url('/profile', Auth::id()) }}"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person align-self-center" viewBox="0 0 16 16">
                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                    </svg>
                    <span class="pt-1">{{ Auth::user()->name }}</span></a>
                <a class="btn btn-ligth" href="{{ url('/logout') }}">Logout</a>
                @else
                <a id="login" class="btn me-3 visually-lg-hidden" style="--bs-btn-padding-y: .60rem; --bs-btn-padding-x: 2rem; --bs-btn-font-size: .90rem;" href="{{ url('/login') }}"> LOG IN</a>
                <a id="signup" class="btn visually-lg-hidden" style="--bs-btn-padding-y: .60rem; --bs-btn-padding-x: 2rem; --bs-btn-font-size: .90rem;" href="{{ url('/register') }}"> SIGN UP </a>
                @endif
            </div>
        </div>
    </nav>
    <div class="modal fade" id="searchFilterModal" tabindex="-1" role="dialog" aria-labelledby="searchFilterModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="searchFilterModalLabel">Search Filters</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('searchwfilter')}}">
                    <div class="modal-body">
                        <label for="searchFilterModalInput" class="col-form-label">Search:</label>
                        <input name="text" type="text" class="form-control" id="searchFilterModalInput" placeholder="Search for...">
                        <label for="searchFilterModalSelect" class="col-form-label">Category:</label>
                        <select name="event_tag" class="form-select" id="searchFilterModalSelect">
                            <option selected>Choose category</option>
                            <option value="1">Cultura</option>
                            <option value="2">Desporto</option>
                            <option value="3">Outdoor</option>
                            <option value="4">Indoor</option>
                            <option value="5">Comédia</option>
                            <option value="6">Exposição</option>
                            <option value="7">Música</option>
                            <option value="8">Para Casal</option>
                            <option value="9">Conferência</option>
                            <option value="10">Ciência</option>
                            <option value="11">Família</option>
                            <option value="12">Arte</option>
                            <option value="13">Cinema</option>
                            <option value="14">Teatro</option>
                            <option value="15">Dança</option>
                            <option value="16">Literatura</option>
                            <option value="17">Festas</option>
                            <option value="18">Gastronomia</option>
                            <option value="19">Online</option>
                            <option value="20">Festivais</option>
                        </select>
                        <label for="searchFilterModalSelect" class="col-form-label">Location:</label>
                        <input name="location" type="text" class="form-control" id="searchFilterModalLocationInput" placeholder="Where... (e.g. Porto)">
                        <label for="searchFilterModalSelect" class="col-form-label">Price:</label>
                        <input name="ticket" type="text" class="form-control" id="searchFilterModalPriceInput" placeholder="0€">
                        <label for="searchFilterModalSelect" class="col-form-label">Start Date after:</label>
                        <input name="start_date" type="date" class="form-control" id="searchFilterModalStartDateInput">
                        <label for="searchFilterModalSelect" class="col-form-label">End Date before:</label>
                        <input name="end_date" type="date" class="form-control" id="searchFilterModalEndDateInput">
                        <label for="searchFilterModalSelect" class="col-form-label">Sort by:</label>
                        <select name="sort_by" class="form-select" id="searchFilterModalSortBySelect">
                            <option selected>Sort by</option>
                            <option value="created_at">Recent</option>
                            <option value="votes">Votes</option>
                            <option value="comments">Comments</option>
                            <option value="start_date">Start date</option>
                            <option value="end_date">End date</option>
                            <option value="ticket">Price</option>
                            <option value="location">Location</option>
                            <option value="name">Title</option>
                            <option value="atteendees">Attendants</option>
                        </select>
                        <label for="searchFilterModalSelect" class="col-form-label">Sort order:</label>
                        <select name="order_by" class="form-select" id="searchFilterModalSortOrderSelect">
                            <option selected value="asc">Ascending</option>
                            <option value="desc">Descending</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</header>