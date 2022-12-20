<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Styles -->
  <link href="{{ asset('css/milligram.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('css/static.css') }}" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/221bee115b.js" crossorigin="anonymous"></script>
  <script>
    // Fix for Firefox autofocus CSS bug
    // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
  </script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap');
  </style>
  <script src={{ asset('js/app.js') }} defer></script>
  <script src={{ asset('js/static.js') }} defer></script>
  <script src={{ asset('js/profile.js') }} defer></script>
  <script src={{ asset('js/invite.js') }} defer></script>
  <script src={{ asset('js/editProfile.js') }} defer></script>
  <script src={{ asset('js/comment.js') }} defer></script>
  <script src={{ asset('js/event.js') }} defer></script>
</head>
<title></title>
<link rel="icon" href="{!! asset('/images/logo.png') !!}" />

<body>
  @include("partials.header")
  <main>
    @if( Session::has('message'))
    <div class="alert alert-success" role="alert">
      {{ Session::get('message')}}
    </div>
    @endif
    @if( Session::has('error'))
    <div class="alert alert-error" role="alert">
      {{ Session::get('error')}}
    </div>
    @endif
    <section id="content">
      @yield('content')
    </section>
  </main>
  @include("partials.footer")
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
</body>

</html>