<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="boxicons.min.css">
</head>



<body class="font-sans antialiased">
    @if(Session::has('success'))
    <div class="fixed top-4 right-4 rounded-lg shadow-md bg-green-800 text-gray-100 px-5 py-4" id="message">
        <p>{{ session('success') }}</p>
    </div>
    <script>
        setTimeout(() => {
            document.getElementById('message').style.display = 'none';
        }, 2000);
    </script>
    @endif

    @if(Session::has('fail'))
    <div class="fixed top-4 right-4 rounded-lg shadow-md bg-red-800 text-gray-100 px-5 py-4" id="error">
        <p>{{ session('fail') }}</p>
    </div>
    <script>
        setTimeout(() => {
            document.getElementById('error').style.display = 'none';
        }, 2000);
    </script>
    @endif
    <div class="flex">
        <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" />

        <div class="min-h-screen flex flex-row bg-green-500">
            <div class="flex flex-col w-56 bg-green-800 overflow-hidden">
                <div style=" padding: 20px; text-align: center; font-family: Arial, sans-serif; color: white; font-size: 24px; border-bottom: 4px solid white;">
                    <h1 style="margin: 0; font-weight: bold; ">Aakash Gym <span class="text-yellow-500">Supplements</span></h1>
                </div>

                <ul class="flex flex-col py-4">
                    <li class="hover:bg-blue-900">
                        <a href="{{ route('admin.dashboard') }}" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-200 hover:text-gray-100">
                            <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-200"><i class="bx bx-home"></i></span>
                            <span class="text-sm font-medium">Dashboard</span>
                        </a>
                    </li>
                    <li class="hover:bg-blue-900">
                        <a href="{{route('admin.category.index')}}" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-200 hover:text-gray-100">
                            <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-200"><i class='bx bx-category'></i></span>
                            <span class="text-sm font-medium">Categories</span>
                        </a>
                    </li>
                    <li class="hover:bg-blue-900">
                        <a href="{{ route('admin.products.enhanced') }}" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-200 hover:text-gray-100">
                            <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-200"><i class="bx bx-package"></i></span>
                            <span class="text-sm font-medium">Products</span>
                        </a>
                    </li>
                    <li class="hover:bg-blue-900">
                        <a href="{{route('admin.order')}}" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-200 hover:text-gray-100">
                            <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-200"><i class="bx bx-shopping-bag"></i></span>
                            <span class="text-sm font-medium">Orders</span>
                        </a>
                    </li>
                    <li class="hover:bg-blue-900">
                        <a href="{{route('admin.payment')}}" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-200 hover:text-gray-100">
                            <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-200"><i class="bx bx-credit-card"></i></span>
                            <span class="text-sm font-medium">Payments</span>
                        </a>
                    </li>
                    <li class="hover:bg-blue-900">
                        <a href="{{ route('admin.customers.index') }}" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-200 hover:text-gray-100">
                            <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-200"><i class="bx bx-users"></i></span>
                            <span class="text-sm font-medium">Customers</span>
                        </a>
                    </li>
                    <li class="hover:bg-blue-900">
                        <a href="{{ route('admin.stock.index') }}" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-200 hover:text-gray-100">
                            <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-200"><i class="bx bx-box"></i></span>
                            <span class="text-sm font-medium">Stock</span>
                        </a>
                    </li>
                    <li class="hover:bg-blue-900">
                        <a href="{{ route('admin.analytics') }}" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-200 hover:text-gray-100">
                            <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-200"><i class="bx bx-bar-chart-alt-2"></i></span>
                            <span class="text-sm font-medium">Analytics</span>
                        </a>
                    </li>

                    <li class="hover:bg-blue-900">
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-200 hover:text-gray-100 w-full text-left">
                                <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-200"><i class="bx bx-log-out"></i></span>
                                <span class="text-sm font-medium">Logout</span>
                            </button>
                        </form>
                        
                    </li>
                </ul>
            </div>
        </div>
        <div class="p-4 flex-1">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

</body>

</html>