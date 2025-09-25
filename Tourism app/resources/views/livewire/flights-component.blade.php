<div>
    
    <div class="flex items-center justify-end px-4">
        {{-- Wire رح نعرف بالكومبونينت showCreateModal Posts.php --}}
        <x-button wire:click="showCreateModal">
            {{__('create Flight')}}
        </x-button>
    </div>
    
    <table class="w-full devide-y devide-gray-200 ">
    
        <thead>
            <tr>
                <th class="px-6 py-3 tracking-wider text-left text-red-500 border-b-2 border-gray-200">id</th>
                <th class="px-6 py-3 tracking-wider text-left text-blue-500 border-b-2 border-gray-200">images</th>
                <th class="px-6 py-3 tracking-wider text-left text-blue-500 border-b-2 border-gray-200">From</th>
                <th class="px-6 py-3 tracking-wider text-left text-blue-500 border-b-2 border-gray-200">To</th>
                <th class="px-6 py-3 tracking-wider text-left text-blue-500 border-b-2 border-gray-200">Date</th>
                <th class="px-6 py-3 tracking-wider text-left text-blue-500 border-b-2 border-gray-200">Time</th>
                <th class="px-6 py-3 tracking-wider text-left text-blue-500 border-b-2 border-gray-200">Company</th>
                <th class="px-6 py-3 tracking-wider text-left text-blue-500 border-b-2 border-gray-200">Ticket</th>
                <th class="px-6 py-3 tracking-wider text-left text-blue-500 border-b-2 border-gray-200">Action</th>
            </tr>
        </thead>
    
        <tbody class="bg-white devide-y devide-gray-200">
    
            @forelse($flights as $flight)
            <tr>
                <td class="px-6 py-3 text-red-500 border-b border-gray-200">{{ $flight->id }}</td>
                <td class="px-6 py-3 border-b border-gray-200"><img src="{{ asset('storage/images/flight.jfif') }}"
                        alt="{{$flight->image->data }}" width="200px"></td>
                <td class="px-6 py-3 border-b border-gray-200">{{ $flight->from }}</td>
                <td class="px-6 py-3 border-b border-gray-200">{{ $flight->to }}</td>
                <td class="px-6 py-3 border-b border-gray-200">{{ $flight->date }}</td>
                <td class="px-6 py-3 border-b border-gray-200">{{ $flight->time }}</td>
                <td class="px-6 py-3 border-b border-gray-200">{{ $flight->company }}</td>
                <td class="px-6 py-3 border-b border-gray-200">{{ $flight->ticket_price }}</td>
                <td class="px-6 py-3 border-b border-gray-200">
                    <div class="flex items-center justify-evenly ">
                        <x-button class="mr-2" wire:click="showUpdateModal({{ $flight->id }})">
                            {{__('Edit')}}
                        </x-button>
    
                        <x-danger-button wire:click="deleteflight({{ $flight->id }})">
                            {{__('Delete')}}
                        </x-danger-button>
                    </div>
    
    
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4">No Flights Found</td>
            </tr>
            @endforelse
    
        </tbody>
    </table>
    <div class="pt-4">
        {{$flights->links() }}
    </div>



    {{-- Create destination model --}}
    
        <x-dialog-modal wire:model='modalFormVisible'>
            <x-slot name="title">
                {{__('Create Flights')}}
            </x-slot>
        
        
            <x-slot name="content">
        
                <div class="mt-4">
                    <x-label for="from" value="{{__('From')}}"></x-label>
                    <x-input type="text" id="from" wire:model="from" class="block w-full mt-2"></x-input>
        
                    @error('from')
                    <span class="text-red-900 text-l ">{{$message}}</span>
                    @enderror
                </div>
        
                <div class="mt-4">
                    <x-label for="to" value="{{__('To')}}"></x-label>
                    <x-input type="text" id="to" wire:model="to" class="block w-full mt-2"></x-input>
        
                    @error('to')
                    <span class="text-red-900 text-l ">{{$message}}</span>
                    @enderror
                </div>
        
                <div class="mt-4">
                    <x-label for="date" value="{{__('Date')}}"></x-label>
                    <x-input type="text" id="date" wire:model="date" class="block w-full mt-2"></x-input>
        
                    @error('date')
                    <span class="text-red-900 text-l ">{{$message}}</span>
                    @enderror
                </div>
        
                <div class="mt-4">
                    <x-label for="time" value="{{__('Time')}}"></x-label>
        
                    <x-input type="text" id="time" wire:model="time" class="block w-full mt-2"></x-input>        
                    @error('time')
                    <span class="text-red-900 text-l ">{{$message}}</span>
                    @enderror
                </div>
                
                
                <div class="mt-4">
                    <x-label for="company" value="{{__('Company')}}"></x-label>
        
                    <x-input type="text" id="company" wire:model="company" class="block w-full mt-2"></x-input>
        
                    @error('company')
                    <span class="text-red-900 text-l ">{{$message}}</span>
                    @enderror
                </div>
                
                <div class="mt-4">
                    <x-label for="ticket" value="{{__('Ticket')}}"></x-label>
        
                    <x-input type="text" id="ticket" wire:model="ticket" class="block w-full mt-2"></x-input>
        
                    @error('ticket')
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
                {{__('Update Flights')}}
            </x-slot>
        
        
            <x-slot name="content">
        
                <div class="mt-4">
                    <x-label for="from" value="{{__('From')}}"></x-label>
                    <x-input type="text" id="from" wire:model="from" class="block w-full mt-2"></x-input>
        
                    @error('from')
                    <span class="text-red-900 text-l ">{{$message}}</span>
                    @enderror
                </div>
        
                <div class="mt-4">
                    <x-label for="to" value="{{__('To')}}"></x-label>
                    <x-input type="text" id="to" wire:model="to" class="block w-full mt-2"></x-input>
        
                    @error('to')
                    <span class="text-red-900 text-l ">{{$message}}</span>
                    @enderror
                </div>
        
                <div class="mt-4">
                    <x-label for="date" value="{{__('Date')}}"></x-label>
                    <x-input type="text" id="date" wire:model="date" class="block w-full mt-2"></x-input>
        
                    @error('date')
                    <span class="text-red-900 text-l ">{{$message}}</span>
                    @enderror
                </div>
        
                <div class="mt-4">
                    <x-label for="time" value="{{__('Time')}}"></x-label>
        
                    <x-input type="text" id="time" wire:model="time" class="block w-full mt-2"></x-input>
        
                    @error('time')
                    <span class="text-red-900 text-l ">{{$message}}</span>
                    @enderror
                </div>
        
        
                <div class="mt-4">
                    <x-label for="company" value="{{__('Company')}}"></x-label>
        
                    <x-input type="text" id="company" wire:model="company" class="block w-full mt-2"></x-input>
        
                    @error('company')
                    <span class="text-red-900 text-l ">{{$message}}</span>
                    @enderror
                </div>
                
                <div class="mt-4">
                    <x-label for="ticket" value="{{__('Ticket')}}"></x-label>
        
                    <x-input type="text" id="ticket" wire:model="ticket" class="block w-full mt-2"></x-input>
        
                    @error('ticket')
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
