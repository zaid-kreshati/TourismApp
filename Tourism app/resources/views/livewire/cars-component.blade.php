<div>
    
        <div>
            <div class="flex items-center justify-end px-4">
                {{-- Wire رح نعرف بالكومبونينت showCreateModal Posts.php --}}
                <x-button wire:click="showCreateModal">
                    {{__('create Car')}}
                </x-button>
            </div>
    
            <table class="w-full devide-y devide-gray-200 ">
    
                <thead>
                    <tr>
                        <th class="px-6 py-3 tracking-wider text-left text-red-500 border-b-2 border-gray-200">id</th>
                        <th class="px-6 py-3 tracking-wider text-left text-blue-500 border-b-2 border-gray-200">images</th>
                        <th class="px-6 py-3 tracking-wider text-left text-blue-500 border-b-2 border-gray-200">Type</th>
                        <th class="px-6 py-3 tracking-wider text-left text-blue-500 border-b-2 border-gray-200">Number
                            passenger</th>
                        <th class="px-6 py-3 tracking-wider text-left text-blue-500 border-b-2 border-gray-200">Price in day
                        </th>
                        <th class="px-6 py-3 tracking-wider text-left text-blue-500 border-b-2 border-gray-200">Office</th>
                        <th class="px-6 py-3 tracking-wider text-left text-blue-500 border-b-2 border-gray-200">Action</th>
                    </tr>
                </thead>
    
                <tbody class="bg-white devide-y devide-gray-200">
    
                    @forelse($cars as $car)
                    <tr>
                        <td class="px-6 py-3 text-red-500 border-b border-gray-200">{{ $car->id }}</td>
                        <td class="px-6 py-3 border-b border-gray-200"><img
                                src="{{ asset('storage/images/'. $car->image->data) }}" alt="{{$car->image->data }}"
                                width="200px"></td>
                        <td class="px-6 py-3 border-b border-gray-200">{{ $car->type }}</td>
                        <td class="px-6 py-3 border-b border-gray-200">{{ $car->num_person }}</td>
                        <td class="px-6 py-3 border-b border-gray-200">{{ $car->price_day }}</td>
                        <td class="px-6 py-3 border-b border-gray-200">{{ $car->office->name }}</td>
                        <td class="px-6 py-3 border-b border-gray-200">
                            <div class="flex items-center justify-evenly ">
                                <x-button class="mr-2" wire:click="showUpdateModal({{ $car->id }})">
                                    {{__('Edit')}}
                                </x-button>
    
                                <x-danger-button wire:click="deleteCar({{ $car->id }})">
                                    {{__('Delete')}}
                                </x-danger-button>
                            </div>
    
    
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">No Car Found</td>
                    </tr>
                    @endforelse
    
                </tbody>
            </table>
            <div class="pt-4">
                {{$cars->links() }}
            </div>


            
        {{-- Create Car model --}}
        <x-dialog-modal wire:model='modalFormVisible'>
            <x-slot name="title">
                {{__('Create Car')}}
            </x-slot>
        
        
            <x-slot name="content">
        
                <div class="mt-4">
                    <x-label for="type" value="{{__('Type')}}"></x-label>
                    <x-input type="text" id="type" wire:model="type" class="block w-full mt-2"></x-input>
        
                    @error('type')
                    <span class="text-red-900 text-l ">{{$message}}</span>
                    @enderror
                </div>
        
                <div class="mt-4">
                    <x-label for="num_pas" value="{{__('Numper passenger')}}"></x-label>
                    <x-input type="text" id="num_pas" wire:model="num_pas" class="block w-full mt-2"></x-input>
        
                    @error('num_pas')
                    <span class="text-red-900 text-l ">{{$message}}</span>
                    @enderror
                </div>
        
                <div class="mt-4">
                    <x-label for="price" value="{{__('Price in day ')}}"></x-label>
                    <x-input type="text" id="price" wire:model="price" class="block w-full mt-2"></x-input>
        
                    @error('price')
                    <span class="text-red-900 text-l ">{{$message}}</span>
                    @enderror
                </div>
        
                <div class="mt-4">
                    <x-label for="office" value="{{__('Office')}}"></x-label>
        
                    <textarea wire:model='office' id="office" cols="30" rows="10"></textarea>
        
                    @error('office')
                    <span class="text-red-900 text-l ">{{$message}}</span>
                    @enderror
                </div>
        
                <div class="mt-4">
                    <x-label for="image" value="{{__('Image')}}"></x-label>
                    <input type="file" id="image" wire:model="image"
                        class="inline-flex items-center px-3 text-sm text-gray-700 rounded-l-md bg-gray-50" />
        
                    @error('image')
                    <span class="text-red-900 text-l ">{{$message}}</span>
                    @enderror
                </div>
        
        
            </x-slot>
        
        
        
            <x-slot name="footer">
                <x-button wire:click="store">
                    {{__('Save')}}
                </x-button>
        
                <x-secondary-button class="ml-2" wire:click="$toggle('modalFormVisible')">
                    {{__('Cancle')}}
                </x-secondary-button>
            </x-slot>
        
        
        
        </x-dialog-modal>

        
        {{-- Update destination model --}}
        <x-dialog-modal wire:model='updateVisible'>
            <x-slot name="title">
                {{__('Update Car')}}
            </x-slot>
        
        
            <x-slot name="content">
        
                <div class="mt-4">
                    <x-label for="type" value="{{__('Type')}}"></x-label>
                    <x-input type="text" id="type" wire:model="type" class="block w-full mt-2"></x-input>
        
                    @error('type')
                    <span class="text-red-900 text-l ">{{$message}}</span>
                    @enderror
                </div>
        
                <div class="mt-4">
                    <x-label for="num_pas" value="{{__('Numper passenger')}}"></x-label>
                    <x-input type="text" id="num_pas" wire:model="num_pas" class="block w-full mt-2"></x-input>
        
                    @error('num_pas')
                    <span class="text-red-900 text-l ">{{$message}}</span>
                    @enderror
                </div>
        
                <div class="mt-4">
                    <x-label for="price" value="{{__('Price in day ')}}"></x-label>
                    <x-input type="text" id="price" wire:model="price" class="block w-full mt-2"></x-input>
        
                    @error('price')
                    <span class="text-red-900 text-l ">{{$message}}</span>
                    @enderror
                </div>
        
                <div class="mt-4">
                    <x-label for="office" value="{{__('Office')}}"></x-label>
        
                    <textarea wire:model='office' id="office" cols="30" rows="10"></textarea>
        
                    @error('office')
                    <span class="text-red-900 text-l ">{{$message}}</span>
                    @enderror
                </div>
        
                <div class="mt-4">
                    <x-label for="image" value="{{__('Image')}}"></x-label>
                    <input type="file" id="image" wire:model="image"
                        class="inline-flex items-center px-3 text-sm text-gray-700 rounded-l-md bg-gray-50" />
        
                    @error('image')
                    <span class="text-red-900 text-l ">{{$message}}</span>
                    @enderror
                </div>
        
        
            </x-slot>
        
        
        
            <x-slot name="footer">
                <x-button wire:click="update">
                    {{__('Update')}}
                </x-button>
        
                <x-secondary-button class="ml-2" wire:click="$toggle('modalFormVisible')">
                    {{__('Cancle')}}
                </x-secondary-button>
            </x-slot>
        
        
        
        </x-dialog-modal>


        



            
        </div>

        
        
</div>
