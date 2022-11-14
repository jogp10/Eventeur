@extends('layouts.app')

@section('title', 'About Us')
@section('content')
<div class="container-md ">
    <div class="row align-items-center m-5">
        <div class="col " style="text-align:center">
            <h1>About Eventeur</h1>
        </div>
        <div class="col">
            <img src="images/logo_big.png" class="img-fluid" height="300" width="400" alt="...">
        </div>
    </div>
    <div class="fs-4" style="padding:2rem;">
        <p>
            Eventeur is the newest web platform for event management,
            allowing users to smooth their schedules and never miss any good event opportunities.
        </p>
        <p>
            In a world where all kind of events has increasingly gained
            popularity, it can be hard to keep up with all of them as well as the
            feedback and expectations provided by the community as a whole.
        </p>
        <p>
            Eventeur is here to help you with that.
        </p>
    </div>
    <div class="row">
        <div style="padding-left: 5rem; margin-top:3rem; margin-bottom:2rem">
            <h2>The Team</h2>
        </div>
        <div class="col">
            <div class="row">
                <div class="col">
                    <img src="images/perfil.png" class="img-fluid rounded-circle me-4" height="100" width="90" alt="...">
                </div>
                <div class="col" style="flex-grow: 4;">
                    <h3>Bernardo Ferreira</h3>
                    <p>up20XXXXXXX@up.pt</p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <img src="images/perfil.png" class="img-fluid rounded-circle me-4" height="100" width="90" alt="...">
                </div>
                <div class="col" style="flex-grow: 4;">
                    <h3>João Pinheiro</h3>
                    <p>up20XXXXXXX@up.pt</p>
                </div>
            </div>

        </div>
        <div class="col">
            <div class="row">
                <div class="col">
                    <img src="images/perfil.png" class="img-fluid rounded-circle me-4" height="100" width="90" alt="...">
                </div>
                <div class="col" style="flex-grow: 4;">
                    <h3>João Rodrigo</h3>
                    <p>up20XXXXXXX@up.pt</p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <img src="images/perfil.png" class="img-fluid rounded-circle me-4" height="100" width="90" alt="...">
                </div>
                <div class="col" style="flex-grow: 4;">
                    <h3>Telmo Botelho</h3>
                    <p>up20XXXXXXX@up.pt</p>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection