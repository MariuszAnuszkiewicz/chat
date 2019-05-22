<!DOCTYPE html>
<html>
<head>
    <link href="{{ asset('css/errors.css') }}" rel="stylesheet">
    <title>Page not found - 404</title>
</head>
<body class="error-404">
  <h2 class="header-404">{{ "Page not found" }}</h2>
  <div class="content-404"><span></span></div>

  <div class="back-btn-within-404">
     <p><a href="{{ route('chat') }}"><span></span>Home</a></p>
  </div>
</body>
