<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aakash Gym Supplements - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .pattern-bg {
            background-image: 
                radial-gradient(circle at 25px 25px, rgba(16, 185, 129, 0.1) 2px, transparent 2px),
                radial-gradient(circle at 75px 75px, rgba(20, 184, 166, 0.1) 2px, transparent 2px);
            background-size: 100px 100px;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-emerald-50 via-teal-50 to-emerald-100 min-h-screen flex items-center justify-center pattern-bg">
    <div class="w-full max-w-7xl mx-4 bg-white shadow-2xl rounded-3xl overflow-hidden border border-emerald-100">
        <div class="flex flex-col lg:flex-row min-h-[600px]">
            <!-- Image Section -->
            <div class="lg:w-1/2 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-600 to-teal-600 opacity-90"></div>
                <img src="{{asset('clientimage/kisanlogin.jpg')}}" alt="Aakash Gym Supplements Login" class="w-full h-full object-cover">
                <div class="absolute inset-0 flex items-center justify-center p-8">
                    <div class="text-center text-white">
                        <div class="text-5xl font-bold mb-4">
                            Aakash <span class="text-emerald-200">Gym</span>
                        </div>
                        <p class="text-xl opacity-90 mb-6">Your Ultimate Fitness & Supplement Store</p>
                        <div class="flex items-center justify-center space-x-4 text-emerald-200">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Premium Supplements
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Expert Guidance
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Section -->
            <div class="lg:w-1/2 p-8 lg:p-12 flex items-center justify-center">
                <div class="w-full max-w-md">
                    <div class="text-center mb-8">
                        <h1 class="text-4xl font-bold text-gray-800 mb-2">Welcome Back!</h1>
                        <p class="text-gray-600 text-lg">Sign in to your account to continue</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf
                        
                        <!-- Email Address -->
                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-bold text-gray-700">Email Address</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                    </svg>
                                </div>
                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    placeholder="Enter your email"
                                    value="{{ old('email') }}"
                                    required
                                    autofocus
                                    autocomplete="username"
                                    class="w-full pl-10 pr-4 py-3 border-2 border-emerald-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200"
                                />
                            </div>
                            @if($errors->has('email'))
                                <span class="text-red-500 text-sm font-medium">{{ $errors->first('email') }}</span>
                            @endif
                        </div>

                        <!-- Password -->
                        <div class="space-y-2">
                            <label for="password" class="block text-sm font-bold text-gray-700">Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    placeholder="Enter your password"
                                    required
                                    autocomplete="current-password"
                                    class="w-full pl-10 pr-4 py-3 border-2 border-emerald-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200"
                                />
                            </div>
                            @if($errors->has('password'))
                                <span class="text-red-500 text-sm font-medium">{{ $errors->first('password') }}</span>
                            @endif
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between">
                            <label for="remember_me" class="flex items-center">
                                <input
                                    id="remember_me"
                                    type="checkbox"
                                    name="remember"
                                    class="h-4 w-4 text-emerald-600 border-emerald-300 rounded focus:ring-emerald-500"
                                />
                                <span class="ml-2 text-sm text-gray-600">Remember me</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a class="text-sm text-emerald-600 hover:text-emerald-800 font-medium" href="{{ route('password.request') }}">
                                    Forgot password?
                                </a>
                            @endif
                        </div>

                        <!-- Login Button -->
                        <button type="submit" class="w-full bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold py-4 rounded-xl transition duration-300 transform hover:scale-105 shadow-lg flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Sign In
                        </button>

                        <!-- Register Link -->
                        <div class="text-center">
                            <p class="text-gray-600">Don't have an account? 
                                <a href="{{ route('register') }}" class="text-emerald-600 hover:text-emerald-800 font-bold">Create Account</a>
                            </p>
                        </div>

                        <!-- Back Home -->
                        <div class="pt-4">
                            <a href="{{ route('user.index') }}" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 rounded-xl transition duration-200 flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                </svg>
                                Back to Home
                            </a>
                        </div>

                        <!-- Terms -->
                        <p class="text-xs text-gray-500 text-center">
                            By signing in, you agree to our
                            <a href="#" class="text-emerald-600 hover:underline">Terms of Service</a>
                            and
                            <a href="#" class="text-emerald-600 hover:underline">Privacy Policy</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
