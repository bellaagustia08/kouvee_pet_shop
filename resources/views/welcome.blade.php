<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Kouvee Pet Shop</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/app.css') }}">
   
</head>
<body>
    <div id="app">
    <app-component>
    </app-component>
    </div>
    
</body>
<script src="{{ asset('js/app.js') }}"></script>
</html>

