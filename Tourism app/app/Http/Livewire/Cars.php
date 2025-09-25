<?php

namespace App\Http\Livewire;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use app\Models\Car;
class Cars extends Component
{
    use WithPagination, WithFileUploads, LivewireAlert;






    public function all_cars()
    {
        return Car::orderByDesc('id')->paginate(2);
    }
    public function render()
    {
        return view('livewire.car', [
            'cars' => $this->all_cars(),
        ])->with('message', session('message'));
    }
}
