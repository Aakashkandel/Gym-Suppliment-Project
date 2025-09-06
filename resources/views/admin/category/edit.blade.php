@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between w-full">
        <h2 class="text-2xl  font-bold text-gray-700">Category</h2>
        <div class="flex items-center space-x-2">
            <button class="flex items-center justify-center h-8 w-8 rounded-full bg-gray-200 text-gray-500">
                <i class="bx bx-search"></i>
            </button>
            <button class="flex items-center justify-center h-8 w-8 rounded-full bg-gray-200 text-gray-500">
                <i class="bx bx-dots-vertical-rounded"></i>
            </button>
        </div>
    </div>
<div class="flex flex-col w-full max-w-3xl mx-auto mt-10">

    <div class="bg-gray-100 p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold text-green-800 mb-4">Edit Category</h2>
        <form action="{{route('admin.category.update',$category->id)}}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-600">Category Name</label>
                <input type="text" name="name" value="{{$category->name}}" id="category_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" >
                @error('name')
                <p class="text-red-500  mt-2">{{$message}}</p>
            @enderror
            </div>
            
            <div class="mb-4">
                <label for="priority" class="block text-sm font-medium text-gray-600">Priority</label>
                <input type="number" name="priority" value="{{$category->priority}}" id="priority" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" >
                @error('priority')
                <p class="text-red-500 mt-2">{{$message}}</p>
            @enderror
            </div>
            
            <div class="flex justify-end">
                <a href="{{route('admin.category.index')}}" class="px-4 py-2 bg-gray-300 mx-2 text-black rounded-lg shadow-md">Back</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 mx-2 text-white rounded-lg shadow-md">Update Category</button>
            </div>
        </form>
    </div>
</div>
@endsection
