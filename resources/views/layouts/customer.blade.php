<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'JaceTrack - Customer')</title>

    <link rel="shortcut icon" href="{{ asset('images/jacelogoclean.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style_customer_dashboard.css') }}">
</head>

<body>

<div class="d-flex">
    
    {{-- ✅ Sidebar Include --}}
    @include('customer.partials.sidebar')

    <div class="flex-grow-1">
        {{-- ✅ Topbar Include --}}
        @include('customer.partials.topbar')

        {{-- ✅ Page Content --}}
        <main class="container-fluid p-4">
            @yield('content')
        </main>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/preloader.js') }}"></script>

</body>
</html>
