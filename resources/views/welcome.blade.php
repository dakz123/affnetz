<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.x/css/materialdesignicons.min.css" rel="stylesheet">
        <title>Laravel</title>

       <link rel="stylesheet" href="{{asset('css/app.css')}}" class="href">
    </head>
    <body >
      <div id="app">
       <index></index>
      </div>
      <script src="{{asset('js/app.js')}}"></script>  
    </body>
</html>
