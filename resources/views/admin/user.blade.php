@extends('layouts.app')
@section('content')
<div class="flex flex-col w-full">
    <div class="flex items-center justify-between w-full">
        <h2 class="text-2xl font-bold text-gray-700">   User Details</h2>
        <div class="flex items-center space-x-2">
            <button class="flex items-center justify-center h-8 w-8 rounded-full bg-gray-200 text-gray-500">
                <i class="bx bx-search"></i>
            </button>
            <button class="flex items-center justify-center h-8 w-8 rounded-full bg-gray-200 text-gray-500">
                <i class="bx bx-dots-vertical-rounded"></i>
            </button>
        </div>
    </div>

   

    <div class="mt-2">
        <div class="mt-4">
            <div class="overflow-x-auto bg-white rounded-lg shadow-xs">
                <table class="w-full whitespace-nowrap">
                    <thead>
                        <tr class="font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-green-900">
                            <th class="px-4 py-3">S.N</th>
                            <th class="px-4 py-3">User Id</th>
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3">Email</th>

                            <th class="px-4 py-3">Role</th>
                            <th class="px-4 py-3">Created_At</th>
                            <th class="px-4 py-3">Updated_At</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        <?php $i = 1; ?>
                        @foreach($users as $user)
                        <tr class="text-gray-700">
                            <td class="px-4 py-3 border">
                                <div class="flex items-center text-sm">
                                    <div>
                                        <?php echo $i++; ?>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 border">
                                <div class="flex items-center text-sm">
                                    <div>
                                        <p class="font-semibold">{{ $user->id }}</p>
                                    </div>
                                </div>
                            </td>

                           
                            <td class="px-4 py-3 border">
                                <div class="flex items-center text-sm">
                                    <div>
                                        <p class="font-semibold">{{ $user->name}}</p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-4 py-3 border">
                                <div class="flex items-center text-sm">
                                    <div>
                                        <p class="font-semibold">{{ $user->email}}</p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-4 py-3 border">
                                <div class="flex items-center text-sm">
                                    <div>
                                        <p class="font-semibold">{{ $user->role}}</p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-4 py-3 border">
                                <div class="flex items-center text-sm">
                                    <div>
                                        <p class="font-semibold">{{ $user->created_at}}</p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-4 py-3 border">
                                <div class="flex items-center text-sm">
                                    <div>
                                        <p class="font-semibold">{{ $user->updated_at}}</p>
                                    </div>
                                </div>
                            </td>

                           
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
</div>


@endsection
