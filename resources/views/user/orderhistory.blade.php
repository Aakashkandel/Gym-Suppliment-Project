@extends('layouts.usermenu')
@section('content')

<body class="bg-gray-100 text-gray-800 ">
    
    <div class="container mx-auto px-4 py-8">
        

  
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-4 mt-16">
          

            @foreach($orders as $order)
            <div class="bg-gray-100 border-spacing-4 border-gray-900  outline-double outline-gray-300 shadow-lg rounded-lg overflow-hidden">
                <div class="p-6">
                    <h2 class="text-lg font-bold text-gray-800">Order Id: {{$order->id}}</h2>
                    <p class="text-gray-600 mt-2">Total Items: {{$order->items}}</p>
                    <p class="text-gray-600 mt-2">Date: {{$order->order_date}}</p>
                    <p class="text-gray-600 mt-2">Payment Method: {{$order->payment_method}}</p>
                </div>
                <div class="p-4 bg-gray-50">
                   @if($order->payment_status == 'pending')
                   <h3 class="text-lg font-semibold bg-yellow-600 text-center  text-gray-200 rounded p-1"> {{$order->payment_status}}</h3>
                     @elseif($order->payment_status == 'paid')
                        <h3 class="text-lg font-semibold bg-green-600 text-center  text-gray-200 rounded p-1"> {{$order->payment_status}}</h3>
                    @else
                    <h3 class="text-lg font-semibold bg-red-600 text-center  text-gray-200 rounded p-1"> {{$order->payment_status}}</h3>
                    @endif
                    <p class="text-gray-600 mt-2 font-semibold">Total Amount: {{$order->total_amount}}</p>
                    <div class="flex mt-4">
                        <a href="{{route('user.orderproduct',$order->id)}}" class="w-full bg-blue-600 text-white py-2 px-4 rounded-full text-center">View Product</a>
                       @if($order->payment_status == 'pending')
                       <a href="{{route('user.ordercancel',$order->id)}}" class="w-full bg-gray-500 text-white py-2 px-4 rounded-full text-center ml-2">Cancel Order</a>
                        @elseif($order->payment_status == 'rejected')
                        <a href="{{route('user.deleteorder',$order->id)}}" class="w-full bg-gray-500 text-white py-2 px-4 rounded-full text-center ml-2">Delete Order</a>
                        @endif

                    </div>
                </div>
            </div>
            @endforeach
           
        </div>
        @if(count($orders) == 0)
        <div class="text-center mt-52">
            <h2 class="text-3xl text-gray-400 font-semibold">No Orders Found</h2>

        </div>
        @endif

    </div>
</body>
@endsection
