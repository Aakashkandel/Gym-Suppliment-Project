@extends('layouts.usermenu')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-5xl font-bold text-gray-800 mb-4 text-center">About <span class="text-emerald-600">Aakash Gym Supplements</span></h2>
    <div class="flex flex-col sm:flex-row items-center mb-12">
        <div class="sm:w-1/2 p-4">
            <img src="{{ asset('clientimage/aboutus.jpg') }}" alt="About Us" class="w-full h-auto rounded shadow-lg">
        </div>
        <div class="sm:w-1/2 p-4">
            <div class="text">
                <span class="text-gray-500 border-b-2 border-green-600 uppercase">About Us</span>
                <h2 class="my-4 text-3xl font-bold sm:text-4xl">
                    About <span class="text-emerald-600">Aakash Gym Supplements</span>
                </h2>
                <p class="text-gray-700">
                    Welcome to Aakash Gym Supplement, your go-to platform for high-quality gym supplements and fitness products. Our mission is to help fitness enthusiasts achieve their goals with premium supplements. We aim to provide a seamless shopping experience with a wide range of products designed to enhance your fitness journey.
                    <br/><br/>
                    <span class="font-semibold text-green-600">Our Commitment:</span> We are dedicated to offering supplements that meet the highest standards of quality and effectiveness. Our curated selection ensures that you get the best fitness products available.
                    <br/><br/>
                    Our goal is to make your shopping experience as smooth and efficient as possible. Whether you’re looking for specific tools or just exploring, we are here to help you find what you need with ease.
                </p>
            </div>
        </div>
    </div>


    <h2 class="text-2xl text-center bg-gray-200 font-bold text-green-900 py-4">Our Team</h2>
    <div class="px-4 py-5 mx-auto ">
        <div class=" w-5/12 mx-auto text-center">
            
            <div class="bg-gray-100 px-5 py-10 rounded">
                <img class="object-cover w-52 m-auto h-52 rounded-full shadow" src="{{ asset('clientimage/ishika.jpg') }}" alt="Ishika Sigdel" />
                <div class="flex flex-col justify-center mt-2 text-center">
                    <p class="text-lg font-bold">Ishika Sigdel</p>
                    <p class="mb-4 text-xs text-gray-800">Co-Founder</p>
                    <p class="text-sm tracking-wide text-gray-800">
                        Co-founder of Aakash Gym Supplement, Ishika is passionate about providing high-quality fitness supplements and helping people achieve their fitness goals. Contact us at 9763639754 for more information.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
