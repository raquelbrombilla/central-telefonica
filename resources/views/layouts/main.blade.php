<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link rel="icon" type="image/png" href="/assets/logo.png">

    <!-- Jquery e Bootstrap Bundle -->
    <script src="/assets/js/jquery-3.6.1.min.js"></script>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    
    <!-- Jquery Validate e Jquery Mask -->
    <script src="/assets/js/jquery.validate.js"></script>
    <script src="/assets/js/jquery.mask.js"></script>

    <!-- Sweetalert -->
    <script src="/assets/js/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="/assets/css/sweetalert2.min.css">

    <!-- Datatables CSS e JS -->
    <link rel="stylesheet" type="text/css" href="/assets/css/datatables.min.css"/>
    <script type="text/javascript" src="/assets/js/datatables.min.js"></script>
 
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/assets/css/bootstrap-5.min.css">
    
    <!-- Estilos CSS -->
    <link rel="stylesheet" href="/assets/css/main.css">

    <!-- Font Awesome (CDN) -->
    <script src="https://kit.fontawesome.com/8e74da30bd.js" crossorigin="anonymous"></script>

</head>
<body>

    @include('layouts.header')

    <div class="container container-content">
        @yield('content')
    </div>

</body>
</html>