@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-4 border border-dark text-center m-5 p-0 text-center" style="min-height: 600px;">
            <div class="position-relative">
                <img src="images/placeholder.png" class="img-fluid" width="500" height="250" alt="...">
                <img src="images/perfil.png" class="img-fluid rounded-circle position-absolute top-100 start-50 translate-middle" width="100" height="230" alt="...">
            </div>
            
            <h4 class="mt-5 pt-5">{{$account->name}}</h4>
            <hr class="px-5 mx-5">
            @if($account->description === null)
                <p class="pt-3 px-5 mx-5">Write your description...</p>
            @else
                <p class="pt-3 px-5 mx-5">{{$account->description}}</p>
            @endif
            <a href="{{ url('/editProfile') }}" type="button" class="btn btn-primary btn-lg">Edit Profile</a>
        </div>
        <div class="col-8 d-flex flex-column m-5 p-0 w-50">
            <div class="">
                <h3>Invites</h3>
                <div class="border border-grey m-0 my-5 p-0 text-center" style="min">
                    <p class="mt-3 fs-4">There are no invites.</p>
                </div>

            </div>
            <div class="border border-grey m-0 p-0">
                <div class="calendar">
                    <div class="d-flex flex-row justify-content-around align-items-center text-center month">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-caret-left-fill" viewBox="0 0 16 16">
                            <path d="m3.86 8.753 5.482 4.796c.646.566 1.658.106 1.658-.753V3.204a1 1 0 0 0-1.659-.753l-5.48 4.796a1 1 0 0 0 0 1.506z"/>
                            </svg>
                        </div>
                        <div class="date mt-2">
                            <h3>May</h3>
                            <p>Fri May 29, 2020</p>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-caret-right-fill" viewBox="0 0 16 16">
                            <path d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z"/>
                            </svg> 
                        </div>
                    </div>
                    <div class="d-flex flex-wrap days m-0 p-4">
                        <div class="border border-grey m-0 p-4">01</div>
                        <div class="border border-grey m-0 p-4">02</div>
                        <div class="border border-grey m-0 p-4">03</div>
                        <div class="border border-grey m-0 p-4">04</div>
                        <div class="border border-grey m-0 p-4">05</div>
                        <div class="border border-grey m-0 p-4">06</div>
                        <div class="border border-grey m-0 p-4">07</div>
                        <div class="border border-grey m-0 p-4">08</div>
                        <div class="border border-grey m-0 p-4">09</div>
                        <div class="border border-grey m-0 p-4">10</div>
                        <div class="border border-grey m-0 p-4">11</div>
                        <div class="border border-grey m-0 p-4">12</div>
                        <div class="border border-grey m-0 p-4">13</div>
                        <div class="border border-grey m-0 p-4">14</div>
                        <div class="border border-grey m-0 p-4">15</div>
                        <div class="border border-grey m-0 p-4">16</div>
                        <div class="border border-grey m-0 p-4">17</div>
                        <div class="border border-grey m-0 p-4">18</div>
                        <div class="border border-grey m-0 p-4">19</div>
                        <div class="border border-grey m-0 p-4">20</div>
                        <div class="border border-grey m-0 p-4">21</div>
                        <div class="border border-grey m-0 p-4">22</div>
                        <div class="border border-grey m-0 p-4">23</div>
                        <div class="border border-grey m-0 p-4">24</div>
                        <div class="border border-grey m-0 p-4">25</div>
                        <div class="border border-grey m-0 p-4">26</div>
                        <div class="border border-grey m-0 p-4">27</div>
                        <div class="border border-grey m-0 p-4">28</div>
                        <div class="border border-grey m-0 p-4">29</div>
                        <div class="border border-grey m-0 p-4">30</div>
                        <div class="border border-grey m-0 p-4">31</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection