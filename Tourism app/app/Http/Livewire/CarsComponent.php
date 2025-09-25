<?php

namespace App\Http\Livewire;

use App\Models\CarOffice;
use App\Models\Image;
use Livewire\Component;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Car;
use Storage;
class CarsComponent extends Component
{

    use WithPagination, WithFileUploads, LivewireAlert;

    public $modalFormVisible = false;
    public $updateVisible = false;

    public $carUpdatedId;
    public $type;
    public $num_pas;
    public $image;
    public $image_name;
    public $img_id;
    public $office;
    public $price;


    //----- Store created dest
    public function showCreateModal()
    {
        $this->modalFormVisible = true;
    }
    public function store()
    {


        if ($this->image) {
            $this->image_name = $this->image->getClientOriginalName();

            // Create image in table and get the id
            $id = Image::create([
                'data' => $this->image_name
            ]);
            $this->img_id = $id->id;

            // will stored in public/storage/images directory 
            $this->image->storeAs('public/images/', $this->image_name);
        }

        $office = CarOffice::where('name', 'LIKE', '%' . $this->office . '%')->first();

        Car::create([
            'type' => $this->type,
            'num_person' => $this->num_pas,
            'img_id' => $this->img_id,
            'price_day' =>$this->price,
            'office_id' => $office->id,
            'isRental'=> 0,
        ]);

        $this->modalFormReset();
        $this->modalFormVisible = false;

        $this->alert('success', 'Car Created Succeffully');
    }



    //----- Update Stuff
    public function showUpdateModal($id)
    {
        $this->updateVisible = true;
        $this->loadData($id);
        $this->alert('info', $id, [
            'position' => 'top-end',
            'timer' => 1000,
            'toast' => true
        ]);

        $this->carUpdatedId = $id;
    }
    public function loadData($car_id)
    {
        $data = Car::find($car_id);
        $this->type = $data->type;
        $this->num_pas = $data->num_person;
        $this->office = $data->office->name;
        $this->price = $data->price_day;
    }
    public function update()
    {

        if ($this->image) {
            $this->image_name = $this->image->getClientOriginalName();

            // Create image in table and get the id
            $id = Image::create([
                'data' => $this->image_name
            ]);
            $this->img_id = $id->id;

            // will stored in public/storage/images directory 
            $this->image->storeAs('public/images/', $this->image_name);
        }

        $office = CarOffice::where('name', 'LIKE', '%' . $this->office . '%')->first();

        $car = Car::find($this->carUpdatedId);
        $car->type = $this->type;
        $car->num_person = $this->num_pas;
        $car->price_day = $this->price;
        $car->office_id = $office->id;
        $car->img_id = $this->img_id;
        $car->save();


        $this->modalFormReset();
        $this->alert('success', 'Destination ' . $this->carUpdatedId . ' Updated Succeffully');
        $this->updateVisible = false;

    }


    //----- Delete Dest 
    public function deleteCar($car_id)
    {
        $this->alert('warning', ' Destination Deleted ! ', ['timer' => 3000]);
        $car = Car::findOrFail($car_id);
        if ($car->image->data) {
            // Storage::delete('public/storage/images/' . $post->image); NOTE DELETED

            // this is right path 
            Storage::disk('public')->delete('images/' . $car->image);
        }
        $car->delete();
    }








    public function all_cars()
    {
        return Car::orderByDesc('id')->paginate(3);
    }
    public function modalFormReset()
    {
        $this->type = null;
        $this->price = null;
        $this->office = null;
        $this->num_pas = null;
    }
    public function render()
    {
        return view('livewire.cars-component' ,[
            'cars' => $this->all_cars(),
        ])->with('message', session('message'));
    }
}
