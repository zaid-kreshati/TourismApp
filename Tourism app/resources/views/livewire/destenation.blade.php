<div>
    <div>
    
        <div class="flex items-center justify-end px-4">
            {{-- Wire رح نعرف بالكومبونينت showCreateModal Posts.php --}}
            <x-button wire:click="showCreateModal" >
                {{__('create Destination')}}
            </x-button>
        </div>
    
        <table class="w-full devide-y devide-gray-200 ">
    
            <thead>
                <tr>
                    <th class="px-6 py-3 tracking-wider text-left text-red-500 border-b-2 border-gray-200">id</th>
                    <th class="px-6 py-3 tracking-wider text-left text-blue-500 border-b-2 border-gray-200">images</th>
                    <th class="px-6 py-3 tracking-wider text-left text-blue-500 border-b-2 border-gray-200">Title</th>
                    <th class="px-6 py-3 tracking-wider text-left text-blue-500 border-b-2 border-gray-200">Details</th>
                    <th class="px-6 py-3 tracking-wider text-left text-blue-500 border-b-2 border-gray-200">Category</th>
                    <th class="px-6 py-3 tracking-wider text-left text-blue-500 border-b-2 border-gray-200">Country</th>
                    <th class="px-6 py-3 tracking-wider text-left text-blue-500 border-b-2 border-gray-200">Action</th>
                </tr>
            </thead>
    
            <tbody class="bg-white devide-y devide-gray-200">
    
                @forelse($dests as $dest)
                <tr>
                    <td class="px-6 py-3 text-red-500 border-b border-gray-200">{{ $dest->id }}</td>
                    <td class="px-6 py-3 border-b border-gray-200"><img src="{{ asset('storage/images/'. $dest->image->data) }}" 
                            alt="{{$dest->image->data }}" width="200px"></td>
                    <td class="px-6 py-3 border-b border-gray-200">{{ $dest->name }}</td>
                    <td class="px-6 py-3 border-b border-gray-200">{{ $dest->details }}</td>
                    <td class="px-6 py-3 border-b border-gray-200">{{ $dest->category->name }}</td>
                    <td class="px-6 py-3 border-b border-gray-200">{{ $dest->country->name }}</td>
                    <td class="px-6 py-3 border-b border-gray-200">
                        <div class="flex items-center justify-evenly ">
                            <x-button class="mr-2" wire:click="showUpdateModal({{ $dest->id }})">
                                {{__('Edit')}}
                            </x-button>
    
                            <x-danger-button wire:click="deleteDest({{ $dest->id }})" >
                                {{__('Delete')}}
                            </x-danger-button>
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
        {{$dests->links() }}
    </div>






    
    {{-- Create destination model  --}}
    <x-dialog-modal wire:model='modalFormVisible'>
        <x-slot name="title">
            {{__('Create Destination')}}
        </x-slot>


        <x-slot name="content">
        
            <div class="mt-4">
                <x-label for="name" value="{{__('Title')}}"></x-label>
                <x-input type="text" id="name" wire:model="name" class="block w-full mt-2"></x-input>
        
                @error('name')
                <span class="text-red-900 text-l ">{{$message}}</span>
                @enderror
            </div>
            
            <div class="mt-4">
                <x-label for="category" value="{{__('Category')}}"></x-label>
                <x-input type="text" id="category" wire:model="category" class="block w-full mt-2"></x-input>
        
                @error('category')
                <span class="text-red-900 text-l ">{{$message}}</span>
                @enderror
            </div>
            
            <div class="mt-4">
                <x-label for="country" value="{{__('Country')}}"></x-label>
                <x-input type="text" id="country" wire:model="country" class="block w-full mt-2"></x-input>
        
                @error('country')
                <span class="text-red-900 text-l ">{{$message}}</span>
                @enderror
            </div>
        
            <div class="mt-4">
                <x-label for="details" value="{{__('Details')}}"></x-label>
        
                <textarea wire:model='details' id="details" cols="30" rows="10"></textarea>
        
                @error('details')
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
            {{__('Update Destination')}}
        </x-slot>


        <x-slot name="content">
        
            <div class="mt-4">
                <x-label for="name" value="{{__('Title')}}"></x-label>
                <x-input type="text" id="name" wire:model="name" class="block w-full mt-2"></x-input>
        
                @error('name')
                <span class="text-red-900 text-l ">{{$message}}</span>
                @enderror
            </div>
            
            <div class="mt-4">
                <x-label for="category" value="{{__('Category')}}"></x-label>
                <x-input type="text" id="category" wire:model="category" class="block w-full mt-2"></x-input>
        
                @error('category')
                <span class="text-red-900 text-l ">{{$message}}</span>
                @enderror
            </div>
            
            <div class="mt-4">
                <x-label for="country" value="{{__('Country')}}"></x-label>
                <x-input type="text" id="country" wire:model="country" class="block w-full mt-2"></x-input>
        
                @error('country')
                <span class="text-red-900 text-l ">{{$message}}</span>
                @enderror
            </div>
        
            <div class="mt-4">
                <x-label for="details" value="{{__('Details')}}"></x-label>
        
                <textarea wire:model='details' id="details" cols="30" rows="10"></textarea>
        
                @error('details')
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