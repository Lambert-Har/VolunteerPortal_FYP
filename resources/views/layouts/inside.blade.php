<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- icons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- css resources -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.css">

    <!-- js resources -->
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <!-- Include Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <!-- Include Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js"></script>

    <!-- Link to app.css using asset() -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/datatable/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text css" href="{{ asset('assets/datatable/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/datatable/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/datatable/css/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/datatable/css/style.css') }}">
    
<style>
    table {
    font-family: 'Your Chosen Font', sans-serif;
    font-size: 14px;
}
</style>
</head>

<body>

    <main>
        @yield('content')
    </main>
    <script type="text/javascript" src="{{ asset('assets/datatable/js/jquery-2.2.4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/datatable/js/jszip.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/datatable/js/pdfmake.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/datatable/js/vfs_fonts.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/datatable/js/buttons.html5.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/datatable/js/buttons.print.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/datatable/js/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/datatable/js/jquery.mark.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/datatable/js/datatables.mark.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/datatable/js/buttons.colVis.min.js') }}"></script>

    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
</body>

</html>
