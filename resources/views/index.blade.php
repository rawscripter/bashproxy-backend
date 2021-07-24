<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;800&display=swap" rel="stylesheet">
    <title> Dashboard | BashProxy </title>
    <script src="https://js.stripe.com/v3/"></script>
    <link rel="stylesheet" href="{{asset('css/app.css')}}?time={{time()}}">
    <style>
        body {
            overflow-x: hidden;
        }
    </style>
    @csrf
</head>
<body>
<div id="app">

</div>
</body>
<script src="{{asset('js/app.js')}}?time={{time()}}"></script>

</html>
