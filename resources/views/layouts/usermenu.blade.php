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

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary-color: #2C3E50 !important;
            --primary-light: #34495e !important;
            --primary-dark: #1a252f !important;
            --secondary-color: #F39C12 !important;
            --secondary-light: #f4a62a !important;
            --secondary-dark: #d68910 !important;
        }

        /* Override Tailwind classes */
        .bg-blue-900 {
            background-color: #2C3E50 !important;
        }

        body .menuitem a {
            color: #fff !important;
            text-decoration: none !important;
            font-size: 1.2rem !important;
            font-weight: 500 !important;
            transition: all 0.3s ease !important;
        }

        body .menuitem a:hover {
            color: #F39C12 !important;
            transform: scale(1.05) !important;
            transition: all 0.3s ease !important;
        }

        body .bg-primary { 
            background-color: #2C3E50 !important; 
        }
        body .bg-secondary { 
            background-color: #F39C12 !important; 
        }
        body .text-primary { 
            color: #2C3E50 !important; 
        }
        body .text-secondary { 
            color: #F39C12 !important; 
        }
        
        /* Force header styles */
        header {
            background-color: #2C3E50 !important;
        }
        
        /* Force footer styles */
        footer {
            background-color: #2C3E50 !important;
        }
    </style>

    <script>
        // Force apply color scheme immediately
        (function() {
            const style = document.createElement('style');
            style.innerHTML = `
                :root {
                    --primary-color: #2C3E50 !important;
                    --secondary-color: #F39C12 !important;
                }
                .bg-blue-900, header {
                    background-color: #2C3E50 !important;
                }
                .text-yellow-500, .text-yellow-400 {
                    color: #F39C12 !important;
                }
            `;
            document.head.appendChild(style);
        })();
    </script>
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
    <header class="bg-primary p-4 fixed w-full z-50 shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <div class="text-2xl font-bold text-white">KisanTools <span class="text-secondary">Supplements</span></div>
            <nav class="space-x-4 menuitem">
                <a href="{{route('user.index')}}" class="text-gray-200 ">Home</a>
                <a href="{{route('user.shop')}}" class="text-gray-200 ">Shop</a>
                @auth
                <a href="{{route('user.orderhistory')}}" class="text-gray-200 ">Order History</a>

                @endauth
                <a href="{{route('user.aboutus')}}" class="text-gray-200 ">Aboutus</a>
            </nav>
            <div class="flex items-center space-x-4 ">



                @auth

                <div class="flex items-center space-x-4 mr-10">
                    <span class="text-white text-lg font-semibold">
                        Welcome, <span class="text-secondary">{{auth()->user()->name}}</span>
                    </span>
                   
                </div>

                <a class="text-white font-semibold bg-secondary px-5 py-2 rounded-xl mx-2 hover:bg-yellow-600 transition-colors" href="{{route('user.cart')}}" ><i class="ri-shopping-cart-2-line"></i>cart</a>
                <form action="{{route('logout')}}" method="post" class="inline">
                    @csrf
                    <button class="text-primary font-semibold bg-white px-5 py-2 rounded-xl mx-2 hover:bg-gray-100 transition-colors" type="submit"><i class="ri-logout-box-r-line ">logout</i></button>
                </form>
                @else
                <a class="text-white font-semibold bg-secondary px-5 py-2 rounded-xl mx-2 hover:bg-yellow-600 transition-colors" href="/register">Register</a>
                <a class="text-primary font-semibold bg-white px-5 py-2 rounded-xl mx-2 hover:bg-gray-100 transition-colors" href="/login">Login</a>
                @endauth

            </div>
        </div>
    </header>
    <div class="">
        @yield('content')
    </div>
    <!-- Footer Section -->
    <footer class="bg-primary text-white py-8">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 KisanTools Supplements. All rights reserved.</p>
            <div class="mt-4">
                <a href="#" class="text-gray-300 hover:text-secondary transition-colors">Privacy Policy</a>
                <span class="mx-2 text-secondary">|</span>
                <a href="#" class="text-gray-300 hover:text-secondary transition-colors">Terms of Service</a>
            </div>
        </div>
    </footer>

</body>

</html>