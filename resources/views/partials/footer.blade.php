<footer class="main-footer" style="max-height: 100%">
    <div class="d-flex flex-column flex-md-row justify-content-md-between text-center m-5">
        <div class="mx-5 px-5 order-1 order-md-0">
            <p>{{ config('app.name', 'Laravel') }} Inc &copy; 2022. All rights reserved.</p>
        </div>

        <div class="mx-5 px-5 order-0 order-md-1">
            <ul class="list-inline">
                <li class="list-inline-item">
                    <a href="/">Home</a>
                </li>
                <li class="list-inline-item">
                    <a href="{{ url('/contact')}}">Contact us</a>
                </li>
                <li class="list-inline-item">
                    <a href="{{ url('/about')}}">About</a>
                </li>
                <li class="list-inline-item">
                    <a href="{{ url('/faq')}}">FAQs</a>
                </li>
            </ul>
        </div>
    </div>
    </div>
</footer>