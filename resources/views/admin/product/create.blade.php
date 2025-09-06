@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between w-full">
    <h2 class="text-2xl font-bold text-gray-700">Product</h2>
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
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold text-green-800 mb-4">Create Product</h2>
        <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
              <input hidden name="user_id" value="{{auth()->user()->id}}">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-600">Product Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    @error('name')
                    <p class="text-red-500 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-600">Product Image</label>
                    <input type="file" name="image" id="image" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    @error('image')
                    <p class="text-red-500 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-600">Title</label>
                    <input type="text" name="title" value="{{ old('title') }}" id="title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    @error('title')
                    <p class="text-red-500 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-600">Description</label>
                    <textarea name="description" id="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>{{ old('description') }}</textarea>
                    @error('description')
                    <p class="text-red-500 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="price" class="block text-sm font-medium text-gray-600">Price</label>
                    <input type="number" name="price" value="{{ old('price') }}" id="price" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    @error('price')
                    <p class="text-red-500 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="stock" class="block text-sm font-medium text-gray-600">Stock</label>
                    <input type="number" name="stock" value="{{ old('stock') }}" id="stock" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    @error('stock')
                    <p class="text-red-500 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="category" class="block text-sm font-medium text-gray-600">Category</label>
                    <select name="category_id" id="category" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>


                        @endforeach
                        <!-- Add your categories here -->
                    </select>
                    @error('category')
                    <p class="text-red-500 mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="flex justify-end mt-6">
                <a href="{{ route('admin.product.index') }}" class="px-4 py-2 bg-gray-300 mx-2 text-black rounded-lg shadow-md">Back</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 mx-2 text-white rounded-lg shadow-md">Create Product</button>
            </div>
        </form>
    </div>
</div>

@endsection
