<?php

namespace App\Http\Livewire;

use App\Models\Flight;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class FlightsComponent extends Component
{

    use WithPagination, WithFileUploads, LivewireAlert;

    public $modalFormVisible = false;
    public $updateVisible = false;

    public $flightUpdatedId;
    public $from;
    public $to;
    // public $image;
    // public $image_name;
    public $img_id = 1;
    public $date;
    public $time;
    public $company;
    public $ticket;






    //----- Store created dest
    public function showCreateModal()
    {
        $this->modalFormVisible = true;
    }
    public function store()
    {
        // $this->validate();

        // if ($this->image) {
        //     $this->image_name = $this->image->getClientOriginalName();

        //     // Create image in table and get the id
        //     $id = Image::create([
        //         'data' => $this->image_name
        //     ]);
        //     $this->img_id = $id->id;

        //     // will stored in public/storage/images directory 
        //     $this->image->storeAs('public/images/', $this->image_name);
        // }


        Flight::create([
            'from' => $this->from,
            'to' => $this->to,
            'img_id' => $this->img_id,
            'company' => $this->company,
            'date' => $this->date,
            'time' => $this->time,
            'ticket_price' =>$this->ticket,
            
        ]);

        $this->modalFormReset();
        $this->modalFormVisible = false;

        $this->alert('success', 'Flight Created Succeffully');
    }



    //----- update Stuff
    public function showUpdateModal($id)
    {
        $this->updateVisible = true;
        $this->loadData($id);
        $this->alert('info', $id, [
            'position' => 'top-end',
            'timer' => 1000,
            'toast' => true
        ]);

        $this->flightUpdatedId = $id;
    }
    public function loadData($flight_id)
    {
        $data = Flight::find($flight_id);
        $this->from = $data->from;
        $this->to = $data->to;
        $this->date = $data->date;
        $this->time = $data->time;
        $this->company = $data->company;
        $this->ticket = $data->ticket_price;
    }
    public function update()
    {

        // if ($this->image) {
        //     $this->image_name = $this->image->getClientOriginalName();

        //     // Create image in table and get the id
        //     $id = Image::create([
        //         'data' => $this->image_name
        //     ]);
        //     $this->img_id = $id->id;

        //     // will stored in public/storage/images directory 
        //     $this->image->storeAs('public/images/', $this->image_name);
        // }


        $flight = Flight::find($this->flightUpdatedId);
        $flight->from = $this->from;
        $flight->to = $this->to;
        $flight->img_id = $this->img_id;
        $flight->company = $this->company;
        $flight->date = $this->date;
        $flight->time = $this->time;
        $flight->save();


        $this->modalFormReset();
        $this->alert('success', 'Flight ' . $this->flightUpdatedId . ' Updated Succeffully');
        $this->updateVisible = false;

    }


    //----- Delete flight 
    public function deleteflight($flight_id)
    {
        $this->alert('warning', ' Flight Deleted ! ', ['timer' => 3000]);
        $flight = Flight::findOrFail($flight_id);
        // if ($dest->image->data) {
        //     // Storage::delete('public/storage/images/' . $post->image); NOTE DELETED

        //     // this is right path 
        //     Storage::disk('public')->delete('images/' . $dest->image);
        // }
        $flight->delete();
    }







    public function all_flights()
    {
        return Flight::orderByDesc('id')->paginate(4);
    }
    public function modalFormReset()
    {
        $this->from = null;
        $this->to = null;
        $this->date = null;
        $this->time = null;
        $this->company = null;
        $this->ticket = null;
    }
    public function render()
    {
        return view('livewire.flights-component', [
            'flights' => $this->all_flights(),
        ])->with('message', session('message'));
    }
}
