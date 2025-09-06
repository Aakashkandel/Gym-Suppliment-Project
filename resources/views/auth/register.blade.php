<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aakash Gym Supplement - Register</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .register-photo {
            background-image: url('/path/to/your/image.jpg');
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-900 flex justify-center items-center min-h-screen">
    <div class="w-full max-w-6xl mx-4 sm:mx-auto bg-white shadow-lg sm:rounded-lg flex overflow-hidden my-10">
        <!-- Image Section -->
        <div class="flex-1 bg-indigo-100 hidden lg:flex">
            <div class="w-full bg-cover bg-center register-photo">
                <img src="{{asset('clientimage/registerimage.jpg')}}" alt="Login Photo" class=" object-cover w-full">


            </div>
        </div>
        <!-- Form Section -->
        <div class="lg:w-1/2 xl:w-7/12 p-6 sm:p-12">
            <div class="flex justify-center">
                <div class="w-full max-w-md">
                    <div class="text-green-900 font-semibold text-3xl font-bold text-center">
                        Kisan<span class="text-indigo-400">Tools</span>
                    </div>
                    <div class="flex flex-col mt-4">
                        <h1 class="text-2xl xl:text-3xl font-extrabold text-center">Register</h1>
                        <div class="mt-8">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <!-- Name -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                    <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500" />
                                    <span class="text-red-500 text-xs mt-1">{{ $errors->first('name') }}</span>
                                </div>
                                <!-- Email Address -->
                                <div class="mt-4">
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500" />
                                    <span class="text-red-500 text-xs mt-1">{{ $errors->first('email') }}</span>
                                </div>
                                <!-- Password -->
                                <div class="mt-4">
                                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                    <input id="password" type="password" name="password" required autocomplete="new-password" class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500" />
                                    <span class="text-red-500 text-xs mt-1">{{ $errors->first('password') }}</span>
                                </div>
                                <!-- Confirm Password -->
                                <div class="mt-4">
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500" />
                                    <span class="text-red-500 text-xs mt-1">{{ $errors->first('password_confirmation') }}</span>
                                </div>
                                <!-- Submit Button -->
                                <div class="flex items-center justify-end mt-4">
                                    <button type="submit" class="ml-4 tracking-wide font-semibold bg-indigo-500 text-gray-100 w-full py-4 rounded-lg hover:bg-indigo-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none">
                                        Register
                                    </button>

                                </div>
                                <a href="{{ route('login') }}" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">Already registered?</a>
                                <div class="flex items
                                -center justify-end mt-4">
                                    <a href="{{ route('user.index') }}" class="ml-4 tracking-wide font-semibold bg-gray-200 text-gray-700 w-full py-4 rounded-lg hover:bg-gray-300 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none">
                                        Back Home
                                    </a>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
