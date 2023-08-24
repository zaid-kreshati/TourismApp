<div>
<div>
    
        <div class="flex items-center justify-end px-4">
            {{-- Wire رح نعرف بالكومبونينت showCreateModal Posts.php --}}
            {{-- <x-button wire:click="showCreateModal">
                {{__('create Destination')}}
            </x-button> --}}
        </div>
    
        <table class="w-full devide-y devide-gray-200 ">
    
            <thead>
                <tr>
                    <th class="px-6 py-3 tracking-wider text-left text-red-500 border-b-2 border-gray-200">id</th>
                    <th class="px-6 py-3 tracking-wider text-left text-blue-500 border-b-2 border-gray-200">images</th>
                    <th class="px-6 py-3 tracking-wider text-left text-blue-500 border-b-2 border-gray-200">Type</th>
                    <th class="px-6 py-3 tracking-wider text-left text-blue-500 border-b-2 border-gray-200">number passenger</th>
                    <th class="px-6 py-3 tracking-wider text-left text-blue-500 border-b-2 border-gray-200">Price in day</th>
                    <th class="px-6 py-3 tracking-wider text-left text-blue-500 border-b-2 border-gray-200">Office</th>
                    <th class="px-6 py-3 tracking-wider text-left text-blue-500 border-b-2 border-gray-200">Action</th>
                </tr>
            </thead>
    
            <tbody class="bg-white devide-y devide-gray-200">
    
                @forelse($cars as $car)
                <tr>
                    <td class="px-6 py-3 text-red-500 border-b border-gray-200">{{ $car->id }}</td>
                    <td class="px-6 py-3 border-b border-gray-200"><img
                            src="{{ asset('storage/images/'. $dest->image->data) }}" alt="{{$car->image->data }}"
                            width="200px"></td>
                    <td class="px-6 py-3 border-b border-gray-200">{{ $car->type }}</td>
                    <td class="px-6 py-3 border-b border-gray-200">{{ $car->num_person }}</td>
                    <td class="px-6 py-3 border-b border-gray-200">{{ $car->price_day }}</td>
                    <td class="px-6 py-3 border-b border-gray-200">{{ $car->office->name }}</td>
                    <td class="px-6 py-3 border-b border-gray-200">
                        <div class="flex items-center justify-evenly ">
                            {{-- <x-button class="mr-2" wire:click="showUpdateModal({{ $dest->id }})">
                                {{__('Edit')}}
                            </x-button> --}}
    
                            {{-- <x-danger-button wire:click="deleteDest({{ $dest->id }})">
                                {{__('Delete')}}
                            </x-danger-button> --}}
                        </div>
    
    
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">No Posts Found</td>
                </tr>
                @endforelse
    
            </tbody>
        </table>
        <div class="pt-4">
            {{$cars->links() }}
        </div>
</div>
