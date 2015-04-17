<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title')</title>
    <link rel="stylesheet" type="text/css" href="{{urlResource('assets/css/lib/bootstraps/min/bootstrap.min.css')}}">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="{{urlResource('assets/js/lib/jquery/jquery-1.11.2.js')}}"></script>
    <script>
    var HRM_DOMAIN = "{{{ url('/') }}}";
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
  </head>
  <body>
    @include('includes.header')
    <div class="container">
      @yield('content')
    </div>
    <div class="load-wrapper" id="myModal" tabindex="-1">
      <div id="circularG">
        <div id="circularG_1" class="circularG">
        </div>
        <div id="circularG_2" class="circularG">
        </div>
        <div id="circularG_3" class="circularG">
        </div>
        <div id="circularG_4" class="circularG">
        </div>
        <div id="circularG_5" class="circularG">
        </div>
        <div id="circularG_6" class="circularG">
        </div>
        <div id="circularG_7" class="circularG">
        </div>
        <div id="circularG_8" class="circularG">
        </div>
      </div>
    </div>
  </body>
</html>