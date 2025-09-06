@extends('layouts.app')
@section('content')
    <div class="flex flex-col w-full">
        <div class="flex items-center justify-between w-full">
            <h2 class="text-lg font-semibold text-gray-700">Dashboard</h2>
            <div class="flex items-center space-x-2">
                <button class="flex items-center justify-center h-8 w-8 rounded-full bg-gray-200 text-gray-500">
                    <i class="bx bx-search"></i>
                </button>
                <button class="flex items-center justify-center h-8 w-8 rounded-full bg-gray-200 text-gray-500">
                    <i class="bx bx-dots-vertical-rounded"></i>
                </button>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs">
                <div class="p-3 rounded-full bg-blue-600 bg-opacity-75">
                    <i class="bx bx-home text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="mb-2 text-sm font-medium text-gray-600">Total Users</p>
                    <p class="text-lg font-semibold text-gray-700">{{$users}}</p>
                </div>
            </div>
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs">
                <div class="p-3 rounded-full text-gray-200 bg-green-600 bg-opacity-75">
                    <i class='bx bx-package' ></i>
                </div>
                <div class="ml-4">
                    <p class="mb-2 text-sm font-medium text-gray-600">Total Products</p>
                    <p class="text-lg font-semibold text-gray-700">{{$products}}</p>
                </div>
            </div>
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs">
                <div class="p-3 rounded-full bg-yellow-600 bg-opacity-75">
                    <i class="bx bx-shopping-bag text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="mb-2 text-sm font-medium text-gray-600">Total Orders</p>
                    <p class="text-lg font-semibold text-gray-700">{{$orders->count()}}</p>
                </div>
            </div>
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs">
                <div class="p-3 rounded-full text-gray-200 bg-red-600 bg-opacity-75">
                    <i class='bx bxs-bank' ></i>
                </div>
                <div class="ml-4">
                    <p class="mb-2 text-sm font-medium text-gray-600">Total Payment</p>
                    <p class="text-lg font-semibold text-gray-700">{{$payments}}</p>
                </div>
            </div>
        </div>
        <div class="mt-6">
            <div class="flex items-center justify-between w-full">
                <h2 class="text-lg font-semibold text-gray-700">Recent Orders</h2>
                <a href="{{route('admin.order')}}" class="text-sm font-medium text-blue-600">View all</a>
            </div>
            <div class="mt-4">
                <div class="overflow-x-auto bg-white rounded-lg shadow-xs">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                        <tr class="font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b">
                            <th class="px-4 py-3">Customer</th>
                            <th class="px-4 py-3">Amount</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Date</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach($orders as $order)
                        <tr class="text-gray-700">
                            <td class="px-4 py-3 border">
                                <div class="flex items-center text-sm">
                                    <div class="relative w-8 h-8 mr-3 rounded-full md:block">
                                        <img class="object-cover w-full h-full rounded-full"
                                             src="{{asset('clientimage/user.png')}}" alt="User Avatar">
                                        <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                                    </div>
                                    <div>
                                        <p class="font-semibold">{{$order->user->name}}</p>
                                        <p class="text-xs text-gray-600">{{$order->user->email}}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm border">
                                {{$order->total_amount}}
                            </td>
                            <td class="px-4 py-3 text-xs border">
                                <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full">
                                    {{$order->payment_status}}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm border">
                                {{$order->created_at}}
                            </td>
                        </tr>
                        @endforeach
                        <!-- Repeat similar rows for more orders -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    
    </div>
@endsection
