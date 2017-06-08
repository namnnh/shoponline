<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Fav and touch icons -->
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{URL::asset('assets/ico/apple-touch-icon-144-precomposed.png')}}">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{URL::asset('assets/ico/apple-touch-icon-114-precomposed.png')}}">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{URL::asset('assets/ico/apple-touch-icon-72-precomposed.png')}}">
  <link rel="apple-touch-icon-precomposed" href="{{URL::asset('assets/ico/apple-touch-icon-57-precomposed.png')}}">
  <link rel="shortcut icon" href="assets/ico/favicon.png">
  <title>TSHOP - Bootstrap E-Commerce Parallax Theme </title>
  <!-- Bootstrap core CSS -->
  <link href="{{URL::asset('assets/bootstrap/css/bootstrap.css')}}" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="{{ URL::asset('assets/css/style.css') }}" rel="stylesheet">

  <!-- css3 animation effect for this template -->
  <link href="{{ URL::asset('assets/css/animate.min.css') }}" rel="stylesheet">

  <!-- styles needed by mCustomScrollbar -->
  <link href="{{ URL::asset('assets/css/jquery.mCustomScrollbar.css') }}" rel="stylesheet">

  <!-- styles needed by minimalect -->
  <link href="{{URL::asset('assets/css/jquery.minimalect.min.css')}}" rel="stylesheet">


  <!-- Just for debugging purposes. -->
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->

  <!-- include pace script for automatic web page progress bar  -->

  @yield('css')
  <script>
    paceOptions = {
      elements: true
    };
  </script>

  <script src="{{URL::asset('assets/js/pace.min.js')}}"></script>
</head>

<body>

  @include('_particles._header') 

  @yield('content') 

  @include('_particles._footer') 
  
  @yield('script')

</body>

</html>