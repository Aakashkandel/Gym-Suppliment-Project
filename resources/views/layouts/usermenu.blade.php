<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Aakash Gym Supplements') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary-color: #2C3E50 !important;
            --primary-light: #34495e !important;
            --primary-dark: #1a252f !important;
            --dark-bg: #161e2c !important;
            --secondary-color: #F39C12 !important;
            --secondary-light: #f4a62a !important;
            --secondary-dark: #d68910 !important;
        }

        /* Navbar Styles */
        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px) !important;
            border-bottom: 1px solid rgba(44, 62, 80, 0.1) !important;
            transition: all 0.3s ease !important;
        }

        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.98) !important;
            box-shadow: 0 4px 20px rgba(44, 62, 80, 0.1) !important;
        }

        .nav-link {
            color: #374151 !important;
            font-weight: 600 !important;
            text-decoration: none !important;
            padding: 0.75rem 1rem !important;
            border-radius: 0.5rem !important;
            transition: all 0.3s ease !important;
            position: relative !important;
        }

        .nav-link:hover {
            color: #2C3E50 !important;
            background-color: rgba(44, 62, 80, 0.1) !important;
            transform: translateY(-2px) !important;
        }

        .nav-link.active {
            color: #2C3E50 !important;
            background-color: rgba(44, 62, 80, 0.15) !important;
        }

        .brand-logo {
            font-weight: 800 !important;
            font-size: 1.5rem !important;
            background: linear-gradient(135deg, #2C3E50, #F39C12) !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
            background-clip: text !important;
        }

        .nav-btn {
            padding: 0.75rem 1.5rem !important;
            border-radius: 0.75rem !important;
            font-weight: 600 !important;
            text-decoration: none !important;
            transition: all 0.3s ease !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 0.5rem !important;
        }

        .nav-btn-primary {
            background: linear-gradient(135deg, #2C3E50, #34495e) !important;
            color: white !important;
            border: none !important;
        }

        .nav-btn-primary:hover {
            background: linear-gradient(135deg, #1a252f, #2C3E50) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 8px 25px rgba(44, 62, 80, 0.3) !important;
        }

        .nav-btn-secondary {
            background: transparent !important;
            color: #F39C12 !important;
            border: 2px solid #F39C12 !important;
        }

        .nav-btn-secondary:hover {
            background: #F39C12 !important;
            color: white !important;
            transform: translateY(-2px) !important;
        }

        .mobile-menu {
            display: none !important;
        }

        .mobile-menu.active {
            display: block !important;
        }

        .welcome-text {
            color: #374151 !important;
            font-weight: 600 !important;
        }

        .welcome-name {
            color: #2C3E50 !important;
            font-weight: 700 !important;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .desktop-nav {
                display: none !important;
            }
            
            .mobile-toggle {
                display: block !important;
            }
        }

        /* Project-wide dark background helper */
        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, rgba(22,30,44,0.85), rgba(22,30,44,0.45));
            /* rgba(22,30,44) uses #161e2c */
        }

        footer {
            background: var(--dark-bg) !important;
        }
        /* Map common Tailwind dark utilities to the project's dark color */
        .bg-gray-900 { background-color: var(--dark-bg) !important; }
        .bg-gray-800 { background-color: var(--dark-bg) !important; }

        @media (min-width: 769px) {
            .mobile-toggle {
                display: none !important;
            }
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50">
    @if(Session::has('success'))
    <div class="fixed top-4 right-4 rounded-lg shadow-lg bg-emerald-500 text-white px-6 py-4 z-50" id="message">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            <p>{{ session('success') }}</p>
        </div>
    </div>
    <script>
        setTimeout(() => {
            document.getElementById('message').style.display = 'none';
        }, 3000);
    </script>
    @endif

    @if(Session::has('fail'))
    <div class="fixed top-4 right-4 rounded-lg shadow-lg bg-red-500 text-white px-6 py-4 z-50" id="error">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <p>{{ session('fail') }}</p>
        </div>
    </div>
    <script>
        setTimeout(() => {
            document.getElementById('error').style.display = 'none';
        }, 3000);
    </script>
    @endif

    <!-- Professional Navbar -->
    <header class="navbar fixed w-full z-50 py-3">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center">
                <!-- Brand Logo -->
                <div class="flex items-center">
                    <a href="{{route('user.index')}}" class="brand-logo flex items-center">
                        <i class="fas fa-dumbbell mr-2 text-emerald-600"></i>
                        Aakash Gym <span class="text-teal-600">Supplements</span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <nav class="desktop-nav flex items-center space-x-2">
                    <a href="{{route('user.index')}}" class="nav-link {{ request()->routeIs('user.index') ? 'active' : '' }}">
                        <i class="fas fa-home mr-1"></i>Home
                    </a>
                    <a href="{{route('user.shop')}}" class="nav-link {{ request()->routeIs('user.shop') ? 'active' : '' }}">
                        <i class="fas fa-store mr-1"></i>Shop
                    </a>
                    @auth
                    <a href="{{route('user.orderhistory')}}" class="nav-link {{ request()->routeIs('user.orderhistory') ? 'active' : '' }}">
                        <i class="fas fa-history mr-1"></i>Orders
                    </a>
                    @endauth
                    <a href="{{route('user.aboutus')}}" class="nav-link {{ request()->routeIs('user.aboutus') ? 'active' : '' }}">
                        <i class="fas fa-info-circle mr-1"></i>About
                    </a>
                </nav>

                <!-- User Actions -->
                <div class="flex items-center space-x-3">
                    @auth
                    <!-- Welcome Message -->
                    <div class="hidden lg:flex items-center mr-4">
                        <span class="welcome-text">Welcome, </span>
                        <span class="welcome-name ml-1">{{auth()->user()->name}}</span>
                    </div>

                    <!-- Cart Button -->
                    <a href="{{route('user.cart')}}" class="nav-btn nav-btn-primary relative">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="hidden sm:inline">Cart</span>
                        @if(session('cart') && count(session('cart')) > 0)
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                            {{count(session('cart'))}}
                        </span>
                        @endif
                    </a>

                    <!-- Logout Button -->
                    <form action="{{route('logout')}}" method="post" class="inline">
                        @csrf
                        <button type="submit" class="nav-btn nav-btn-secondary">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="hidden sm:inline">Logout</span>
                        </button>
                    </form>
                    @else
                    <!-- Login/Register Buttons -->
                    <a href="/register" class="nav-btn nav-btn-secondary">
                        <i class="fas fa-user-plus"></i>
                        <span class="hidden sm:inline">Register</span>
                    </a>
                    <a href="/login" class="nav-btn nav-btn-primary">
                        <i class="fas fa-sign-in-alt"></i>
                        <span class="hidden sm:inline">Login</span>
                    </a>
                    @endauth

                    <!-- Mobile Menu Toggle -->
                    <button class="mobile-toggle text-gray-600 hover:text-emerald-600 p-2" onclick="toggleMobileMenu()">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div class="mobile-menu mt-4 pb-4" id="mobileMenu">
                <div class="flex flex-col space-y-2">
                    <a href="{{route('user.index')}}" class="nav-link">
                        <i class="fas fa-home mr-2"></i>Home
                    </a>
                    <a href="{{route('user.shop')}}" class="nav-link">
                        <i class="fas fa-store mr-2"></i>Shop
                    </a>
                    @auth
                    <a href="{{route('user.orderhistory')}}" class="nav-link">
                        <i class="fas fa-history mr-2"></i>Order History
                    </a>
                    @endauth
                    <a href="{{route('user.aboutus')}}" class="nav-link">
                        <i class="fas fa-info-circle mr-2"></i>About Us
                    </a>
                    
                    @guest
                    <div class="pt-4 border-t border-gray-200 mt-4">
                        <a href="/register" class="nav-btn nav-btn-secondary w-full mb-2 justify-center">
                            <i class="fas fa-user-plus mr-2"></i>Register
                        </a>
                        <a href="/login" class="nav-btn nav-btn-primary w-full justify-center">
                            <i class="fas fa-sign-in-alt mr-2"></i>Login
                        </a>
                    </div>
                    @endguest
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="pt-20">
        @yield('content')
    </main>

    <!-- Professional Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center mb-6">
                        <i class="fas fa-dumbbell mr-2 text-2xl" style="color: #F39C12;"></i>
                        <h3 class="text-2xl font-bold">Aakash Gym <span style="color: #F39C12;">Supplements</span></h3>
                    </div>
                    <p class="text-gray-400 mb-4 max-w-md">
                        Your trusted partner in fitness nutrition. We provide premium quality supplements to help you achieve your fitness goals and build your best physique.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 transition-colors" style="hover:color: #F39C12;" onmouseover="this.style.color='#F39C12';" onmouseout="this.style.color='#9ca3af';">
                            <i class="fab fa-facebook text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 transition-colors" style="hover:color: #F39C12;" onmouseover="this.style.color='#F39C12';" onmouseout="this.style.color='#9ca3af';">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 transition-colors" style="hover:color: #F39C12;" onmouseover="this.style.color='#F39C12';" onmouseout="this.style.color='#9ca3af';">
                            <i class="fab fa-youtube text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 transition-colors" style="hover:color: #F39C12;" onmouseover="this.style.color='#F39C12';" onmouseout="this.style.color='#9ca3af';">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-4" style="color: #F39C12;">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="{{route('user.index')}}" class="text-gray-400 hover:text-white transition-colors">Home</a></li>
                        <li><a href="{{route('user.shop')}}" class="text-gray-400 hover:text-white transition-colors">Shop</a></li>
                        <li><a href="{{route('user.aboutus')}}" class="text-gray-400 hover:text-white transition-colors">About Us</a></li>
                        @auth
                        <li><a href="{{route('user.orderhistory')}}" class="text-gray-400 hover:text-white transition-colors">Order History</a></li>
                        @endauth
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h4 class="text-lg font-semibold mb-4" style="color: #F39C12;">Contact Info</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li class="flex items-center">
                            <i class="fas fa-phone mr-2" style="color: #F39C12;"></i>
                            +977 98XXXXXXXX
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-2" style="color: #F39C12;"></i>
                            info@aakashgym.com
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-map-marker-alt mr-2" style="color: #F39C12;"></i>
                            Kathmandu, Nepal
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center">
                <p class="text-gray-400">
                    &copy; 2024 Aakash Gym Supplements. All rights reserved. | 
                    <a href="#" class="transition-colors" style="color: #F39C12;" onmouseover="this.style.opacity='0.8';" onmouseout="this.style.opacity='1';">Privacy Policy</a> | 
                    <a href="#" class="transition-colors" style="color: #F39C12;" onmouseover="this.style.opacity='0.8';" onmouseout="this.style.opacity='1';">Terms of Service</a>
                </p>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        // Mobile menu toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('active');
        }

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('mobileMenu');
            const toggle = document.querySelector('.mobile-toggle');
            
            if (!menu.contains(event.target) && !toggle.contains(event.target)) {
                menu.classList.remove('active');
            }
        });

        // Auto-hide notifications
        document.addEventListener('DOMContentLoaded', function() {
            const notifications = document.querySelectorAll('#message, #error');
            notifications.forEach(notification => {
                if (notification) {
                    setTimeout(() => {
                        notification.style.opacity = '0';
                        notification.style.transform = 'translateX(100%)';
                        setTimeout(() => {
                            notification.style.display = 'none';
                        }, 300);
                    }, 3000);
                }
            });
        });
    </script>
</body>

</html>